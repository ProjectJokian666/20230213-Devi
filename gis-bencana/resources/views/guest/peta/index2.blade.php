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
					<div><span style="background-color: #5cfc00"></span>Rendah ( 1% - 29% )</div>
					<div><span style="background-color: #c8d1e1"></span>Kosong</div>
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
	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';

	const map = new mapboxgl.Map(
	{
        // container ID
		container: 'maps', 
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        // style URL
		style: 'mapbox://styles/mapbox/light-v11',
        // starting position
		center: [112.03, -7.824],
        // starting zoom
		zoom: 10.5,
		maxBounds: device,
	});
	
	var hoveredStateId1 = null;

	$("#btn_lihat").on('click',function() {
		// console.log($("#bencana").val(),$("#tanggal1").val(),$("#tanggal2").val(),);
		Show_Data_Peta();
	})

	Show_Data_Peta();

	function Show_Data_Peta() {
		$.ajax({
			url:"{{route('peta.get_peta')}}",
			type:"GET",
			data : {
				bencana : $("#bencana").val(),
				tanggal1 : $("#tanggal1").val(),
				tanggal2 : $("#tanggal2").val(),
			},
			success:function(data){
				// Bencana = $("#tanggal").val()
				// Rinci = data
				// console.log(Bencana,Rinci,data,data.Bencana,data.Rinci)
				// Bencana = data.Bencana
				// console.log(Bencana)
				// Rinci = data.Rinci
				// console.log(Rinci)
				// console.log($("#tanggal").val())
				Show_Peta(data.Bencana,data.Rinci)
			}
		});
	}

	function Show_Peta(a,b){

	}


	map.on('load', function () {
		// Add an image to use as a custom marker
		map.loadImage('{{asset('/')}}mapbox/custom_marker.png', function(error, image) {
			if (error) {
				throw error
			}
			map.addImage('custom-marker', image);

			map.addSource('maine', {
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': [

						<?php 
						$a = '{';
						$b = ',';

						use App\Models\Bencana;
						use App\Models\BencanaPerWilayah;
						use App\Models\DataBencanaPerWilayah;

						// mengambil data wilayah dan menampilkannya 
						foreach ($data['wilayah'] as $wilayah) { 
							$id = $wilayah->id;


							// get data bencana per wilayah
							$data_bencana = BencanaPerWilayah::where('id_wilayah','=',$wilayah->id)->get();
							$isi = "";
							$total_bencana_per_wilayah = 0;

							if ($data_bencana!=null) {
								foreach ($data_bencana as $db) {
									
									// data bencana
									$nama_bencana = Bencana::find($db->id_bencana);
									$isi .= $nama_bencana->nama_bencana;

									// get data per bencana
									$total_data_bencana = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$db->id_bencana_per_wilayah)->get(); 
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
							echo $a;
						// mengambil file berdasarkan database dan ditampilkan
							echo file_get_contents("Data_Wilayah/".$wilayah->file_wilayah); 
							echo $b;
							echo '"id":'.'"'.$id.'",';
							echo '"properties":{
								"nama":'.'"'.$wilayah->nama_wilayah.'"'.',
								"wilayah":'.'"'.$isi.'"'.',
								"bencana":'.$total_bencana_per_wilayah.'}},
								';

							}
							
							?>
							
							]
				}
			});

			map.addLayer({ // Add a new layer to visualize the polygon.
				'id': 'isi',
				'type': 'fill', // reference the data source
				'source': 'maine', 
				'layout': {},
				'paint': { // blue color fill
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

			map.addLayer({ // Add a black outline around the polygon.
				'id': 'batas',
				'type': 'line',
				'source': 'maine',
				'layout': {},
				'paint': {
					'line-width': 1,
					'line-color': '#f0ffff'
				}
			});

			// map.addLayer({ // Add a layer showing the places.
			// 	'id': 'places',
			// 	'type': 'symbol',
			// 	'source': 'places',
			// 	'layout': {
			// 		'icon-image': 'custom-marker',
			// 		'icon-allow-overlap': true
			// 	}
			// });

			var popup1 = new mapboxgl.Popup({
				closeButton: false,
				closeOnClick: false
			});

			// map.on('click', 'isi', function(e) {
			// 	new mapboxgl.Popup()
			// 	.setLngLat(e.lngLat)
			// 	.setHTML('<h3>' + e.features[0].properties.nama + '</h3><p>' + e.features[0].properties.bencana + ' Bencana</p>')
			// 	.addTo(map);
			// });

			map.on('mousemove', 'isi', function(e) {

				if (e.features.length > 0) {
					if (hoveredStateId1) {
                                // Change the cursor style as a UI indicator.
						map.getCanvas().style.cursor = 'pointer';

                                // Single out the first found feature.
						var feature1 = e.features[0];

                                // Display a popup with the name of the county
						popup1.setLngLat(e.lngLat)
						.setHTML(
							'<p class="text-center">'+
							'<h6>'+
							'<strong>' +
							feature1.properties.nama +
							'</strong>'+
							'</h6>'+
							feature1.properties.wilayah+
							// '<br>' +
							// feature1.properties.bencana+
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

map.on('idle', function() {
	map.resize()
});
});
</script>
@endpush