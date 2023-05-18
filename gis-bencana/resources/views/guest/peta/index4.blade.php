@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
<style type="text/css">
	.legend {
		background-color: #fff;
		border-radius: 3px;
		bottom: 30px;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
		padding: 10px;
		position: absolute;
		right: 10px;
		z-index: 1;
	}

	.legend h4 {
		margin: 0 0 10px;
	}

	.legend div span {
		border-radius: 50%;
		display: inline-block;
		height: 10px;
		margin-right: 5px;
		width: 10px;
	}

	.legend2 {
		background-color: #fff;
		border-radius: 3px;
		bottom: 30px;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
		padding: 10px;
		position: absolute;
		left: 10px;
		z-index: 1;
	}

	.legend2 h4 {
		margin: 0 0 10px;
	}

	.legend2 div span {
		border-radius: 50%;
		display: inline-block;
		height: 10px;
		margin-left: 5px;
		width: 10px;
	}

	.marker {
		background-image: url('mapbox-icon.png');
		background-size: cover;
		width: 50px;
		height: 50px;
		border-radius: 50%;
		cursor: pointer;
	}

	.mapboxgl-popup {
		max-width: 400px;
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
	}

	.coordinates {
		background: rgba(0, 0, 0, 0.5);
		color: #fff;
		position: absolute;
		bottom: 60px;
		left: 40px;
		padding: 5px 10px;
		margin: 0;
		font-size: 11px;
		line-height: 18px;
		border-radius: 3px;
		display: none;
	}
</style>
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<div class="col-12 mt-3">
			<div class="row">
				<div class="col-3">
					<select class="form-control" id="bencana" name="bencana">
						@foreach($data['bencana'] as $key => $value)
						<option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="tanggal1" name="tanggal1">
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="tanggal2" name="tanggal2">
				</div>
				<div class="col-3">
					<button type="button" class="btn btn-primary" id="btn_lihat">Lihat</button>
				</div>
			</div>
		</div>
		<div class="col-12 mt-3">
			<div id="maps" style="height:500px;">
				<div id="state-legend" class="legend">
					<h6>Keterangan</h6>
					<div><span style="background-color: #360602"></span>Tinggi ( 60% - 100% )</div>
					<div><span style="background-color: #fc7600"></span>Medium ( 30% - 59% )</div>
					<div><span style="background-color: #5cfc00"></span>Rendah ( 0% - 29% )</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('jss')
<script src="{{asset('Jquery')}}\jquery-3.6.4.min.js"></script>
<script src="{{asset('mapbox/mapbox-gl.js')}}"></script>
<script>
	var device;
	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            // true for mobile device
		device = [
			[111.75913914489564, -8.669228758626588],
			[112.45263414965126, -7.170129037865038]
			];
	} else {
            // false for not mobile device
		device = [
			[111.52119039287481, -8.040812976926816],
			[112.69129014605602, -7.586629911014967]
			];
	}

	$("#btn_lihat").on('click',function() {
		// console.log($("#bencana").val(),$("#tanggal1").val(),$("#tanggal2").val(),);
		Show_Peta();
	})

	Show_Peta();

	function Show_Peta(){
		// var show_area_wilayah = null

		mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';

		mapboxgl.accessToken = 'pk.eyJ1IjoicGVtZXNhbmFucHJvamVjdCIsImEiOiJjbGZnbHd2MmQxYXpsM3F0YXVnaDE2cmg2In0.KQiqfcQPz718udumsJHPHA';
		const map = new mapboxgl.Map({
			container: 'maps',
			style: 'mapbox://styles/mapbox/streets-v12',
			center: [112.03, -7.824],
			zoom: 10.5
		});

		map.on('load',function(){

			var select_bencana = $("#bencana").val();
			var select_tanggal1 = $("#tanggal1").val();
			var select_tanggal2 = $("#tanggal2").val();

			map.loadImage('{{asset('/')}}mapbox/custom_marker.png',function(error,image) {

				if (error) {
					throw error
				}

				map.addImage('custom-marker', image);

				$.ajax({
					url:"{{route('peta.get_peta')}}",
					type:"GET",
					data : {
						bencana : $("#bencana").val(),
						tanggal1 : $("#tanggal1").val(),
						tanggal2 : $("#tanggal2").val(),
					},
					success:function(data){
						
					},
				});

				console.log('<?php $data_bencana="?>bencana<?php"; ?>')

				map.addSource('maine', {
					'type': 'geojson',
					'data': 
					{
						'type': 'FeatureCollection',
						'features': [
							<?php

							use App\Models\Bencana;
							use App\Models\BencanaPerWilayah;
							use App\Models\DataBencanaPerWilayah;

							// menampilkan data wilayah 
							foreach ($data['wilayah'] as $key => $value_wilayah) {
								$id_bencana="?>select_bencana<?php";

								$data_bencana = Bencana::find($id_bencana);

								$data_bencana_per_wilayah = BencanaPerWilayah::where('id_wilayah','=',$value_wilayah['id'])->get();

									$total_bencana_per_wilayah = 0;
									$isi = "";
									if ($data_bencana_per_wilayah!=null) {
										foreach($data_bencana_per_wilayah as $key => $value_bencana){
											$nama_bencana = Bencana::find($value_bencana['id_bencana']);
												$isi .= $nama_bencana->nama_bencana;

												$total_data_bencana = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$value_bencana['id_bencana_per_wilayah'])->get(); 
													$jumlah_bencana_per_wilayah = 0;
													if ($total_data_bencana!=null) {
														foreach($total_data_bencana as $tdb){
															$jumlah_bencana_per_wilayah += $tdb->jumlah;
															$total_bencana_per_wilayah+=$tdb->jumlah;
														}
													}
													$isi .= " ".$jumlah_bencana_per_wilayah." Kejadian<br>";
												}
											}

											echo '{';
											echo '"id":"'.$value_wilayah['id'].'",';
											echo file_get_contents("Data_Wilayah/".$value_wilayah['file_wilayah']);
												echo "},";
											}

											?>
											]
										}
									});

map.addLayer({
	'id': 'isi',
	'type': 'fill',
	'source': 'maine', 
	'layout': {},
	'paint': {
		'fill-color': [
			"case",
			['<=', ['get', "bencana"], 0], "#c8d1e1",
			['<=', ['get', "bencana"], 29], "#5cfc00",
			['<=', ['get', "bencana"], 59], "#fc7600",
			['<=', ['get', "bencana"], 100], "#360602",
			'#123456'
			],
		'fill-opacity': [
			'case',
			['boolean', ['feature-state', 'hover'], false],
			1,
			0.5
			]
	}
});

map.addLayer({
	'id': 'batas',
	'type': 'line',
	'source': 'maine',
	'layout': {},
	'paint': {
		'line-width': 1,
		'line-color': '#f0ffff'
	}
});

var popup1 = new mapboxgl.Popup({
	closeButton: false,
	closeOnClick: false
});

var hoveredStateId1 = null;

map.on('mousemove', 'isi', function(e) {
	if (e.features.length > 0) {
		if (hoveredStateId1) {
			map.getCanvas().style.cursor = 'pointer';
			var feature1 = e.features[0];
			popup1.setLngLat(e.lngLat)
			.setHTML(
				'<p class="text-center">'+
				'<h6>'+
				'<strong>' +
				feature1.properties.nama +
				'</strong>'+
				'</h6>'+
				feature1.properties.wilayah+
				feature1.properties.bencana+
				'</p>'
				)
			.addTo(map);
			map.setFeatureState({
				source: 'maine',
				id: hoveredStateId1
			}, {
				hover: false
			});
		}
		hoveredStateId1 = e.features[0].id;
		map.setFeatureState({
			source: 'maine',
			id: hoveredStateId1
		}, {
			hover: true
		});
	}
});

map.on('mouseleave', 'isi', function() {
	if (hoveredStateId1) {
		map.getCanvas().style.cursor = '';
		popup1.remove();
		map.setFeatureState({
			source: 'maine',
			id: hoveredStateId1
		}, {
			hover: false
		});
	}
	hoveredStateId1 = null;
});

});

});
}

</script>
@endpush