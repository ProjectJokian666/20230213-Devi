@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<div class="col-12">
			<div id="maps" style="height:500px;width: 100%;"></div>
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
		zoom: 11.5
	});

	map.addControl(new mapboxgl.NavigationControl());
	map.addControl(new mapboxgl.FullscreenControl());


	map.on('load', () => {
            // Add a data source containing GeoJSON data.
		map.addSource('maine', {
			'type': 'geojson',
			'data': {
				'type': 'FeatureCollection',
				'features': [
					<?php 
					foreach ($data['wilayah'] as $wilayah) {
						echo '{'.file_get_contents("Data_Wilayah/".$wilayah->file_wilayah).'},';
					}
					?>
					]
			}
		});

            // Add a new layer to visualize the polygon.
		map.addLayer({
			'id': 'maine',
			'type': 'fill',
                // reference the data source
			'source': 'maine', 
			'layout': {},
			'paint': {
                    // blue color fill
				'fill-color': '#0080ff', 
				'fill-opacity': 0.05
			}
		});
            // Add a black outline around the polygon.
		map.addLayer({
			'id': 'outline',
			'type': 'line',
			'source': 'maine',
			'layout': {},
			'paint': {
				'line-color': '#000',
				'line-width': 0.1
			}
		});
	});
</script>
@endpush