@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<div class="col-12">
			<div id="maps" style="height:500px;">
				@include('layouts.keterangan')
			</div>
		</div>
	</div>
</section>
@endsection
<?php 

$a = asset('geo-map/kota.json');

?>
@push('jss')
<script src="{{asset('mapbox/mapbox-gl.js')}}"></script>
<script>
	// console.log("<?php echo $a; ?>");
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
		zoom: 11.5,
		maxBounds: device,
	});

	var hoveredStateId1 = null;

	map.on('load', function () {
		// Add an image to use as a custom marker
		map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png', function(error, image) {
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
						['<=', ['get', "bencana"], 15], "#008000",
						['<=', ['get', "bencana"], 30], "#FFFF00",
						['<=', ['get', "bencana"], 45], "#FF0000",
						['>', ['get', "bencana"], 60], "#000000",
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

		}
		);//z

map.on('idle', function() {
	map.resize()
});
});
</script>
@endpush