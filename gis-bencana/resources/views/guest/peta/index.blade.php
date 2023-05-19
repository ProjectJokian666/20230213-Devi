@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<div class="col-12 mt-3 mb-3">
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
		<div id="maps" style="height:500px;">
			@include('layouts.keterangan')
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
						console.log(data);
					},
				});

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

								echo '{';
								echo '"id":"'.$value_wilayah['id'].'",';
								echo '"nama":"'.$value_wilayah['nama_wilayah'].'",';
								echo '"bencana":"'.$value_wilayah['nama_wilayah'].'",';
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
							['<=', ['get', "data_bencana"], 0], "#c8d1e1",
							['<=', ['get', "data_bencana"], 29], "#5cfc00",
							['<=', ['get', "data_bencana"], 59], "#fc7600",
							['<=', ['get', "data_bencana"], 100], "#360602",
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