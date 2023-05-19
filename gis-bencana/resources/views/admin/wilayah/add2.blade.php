@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
@endpush

@section('content')
<section class="section dashboard">
	<div class="row">
		@if(session('sukses'))
		<div class="col-12">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{session('sukses')}}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		</div>
		@endif
		@if(session('gagal'))
		<div class="col-12">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{session('gagal')}}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		</div>
		@endif
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="d-flex mt-4 mb-4 justify-content-between">
						<h5>Tambah Data Wilayah</h5>
						<a href="{{route('admin.wilayah')}}" class="btn btn-sm btn-primary">KEMBALI</a>
					</div>
					<form action="{{url('admin/add_wilayah')}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row mb-3">
							<label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
							<div class="col-sm-9">
								<input type="text" name="wilayah" class="form-control" placeholder="Nama Wilayah">
							</div>
						</div>

						<div class="row mb-3">
							<label for="file_wilayah" class="col-sm-3 col-form-label">File Wilayah</label>
							<div class="col-sm-9">
								<input class="form-control" type="file" id="file_wilayah" name="file_wilayah">
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-sm-3">
								
							</div>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">SIMPAN</button>
							</div>
						</div>

					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title" id="urlfile">URL</h5>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Preview File</h5>
				</div>
				<div id="maps" style="height:500px;"></div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('jss')
<script src="{{asset('mapbox/mapbox-gl.js')}}"></script>
<script type="text/javascript">
	var	data_peta = [];

	$('#file_wilayah').change(function(){
		// console.log(this.files);
		previewData(this);
	});

	function previewData(input) {
		// console.log(input.files[0]);
		// console.log($('#file_wilayah').val());
		// if (input.files&&input.files[0]) {
		// 	console.log(input.files);
		// 	console.log(input.files[0]);
		// 	var reader = new FileReader();

		// 	reader.onload = function(e){
		// 		console.log(e.target.result);
		// 		$('#urlfile').text(e.target.result);
		// 	}
		// 	reader.readAsDataURL(input.files[0]);
		// }

		// $.ajax({
		// 	url:"{{url('admin/post_file')}}",
		// 	type:"POST",
		// 	data : {
		// 		'_token':'{{csrf_token()}}',
		// 		file_wilayah : $('#file_wilayah').val(),
		// 	},
		// 	success:function(data){
		// 		console.log(data);
		// 	}
		// });
		// $('#urlfile').load('')
		// console.log()

		const data_file = input.files[0];
		const reader = new FileReader();

		reader.onload = function(e) {
			const fileContent = e.target.result;
			show_peta(fileContent);
			// console.log
			// (
			// 	// fileContent,
			// 	);
			// $('#urlfile').text(fileContent);
		};

		reader.readAsText(data_file);

	}

	// function readFile() {
	// 	const fileInput = document.getElementById('fileInput');
	// 	const file = fileInput.files[0];
	// 	const reader = new FileReader();

	// 	reader.onload = function(e) {
	// 		const fileContent = e.target.result;
	// 		const fileContentDiv = document.getElementById('fileContent');
	// 		fileContentDiv.textContent = fileContent;
	// 	};

	// 	reader.readAsText(file);
	// }

	var device;
	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
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
		container: 'maps',
		style: 'mapbox://styles/mapbox/{{env("MAPBOX_STYLE")}}',
		center: [112.03, -7.824],
		zoom: 11.5,
		maxBounds: device,
	});

	var hoveredStateId1 = null;
	var json_data_peta = data_peta;

	console.log(json_data_peta);
	map.on('load', function () {
		map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png', function(error, image) {
			if (error) {
				throw error
			}
			map.addImage('custom-marker', image);

			map.addSource('maine', {
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': [json_data_peta]
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