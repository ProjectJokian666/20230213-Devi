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
	var data_peta ="";
	show_peta();

	$('#file_wilayah').change(function(){
		previewData(this);
	});

	function previewData(input) {

		const data_file = input.files[0];
		const reader = new FileReader();

		reader.onload = function(e) {
			const fileContent = e.target.result;
			data_peta = fileContent;
			show_peta();
			// console.log(data_peta);
		};

		reader.readAsText(data_file);

	}

	function show_peta(){

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

		map.on('load', function () {
			map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png', function(error, image) {
				if (error) {
					throw error
				}
				map.addImage('custom-marker', image);
				console.log('data_peta');
				map.addSource('maine', {
					'type': 'geojson',
					'data': {
						'type': 'FeatureCollection',
						'features': [{data_peta}]
					}
				});
				console.log('data_peta');

				map.addLayer({ 
					'id': 'isi',
					'type': 'fill', 
					'source': 'maine', 
					'layout': {},
					'paint': {
						'fill-color': '#fc7600',
						'fill-opacity': 0.8
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

			});

			map.on('idle', function() {
				map.resize()
			});
		});
	}

</script>
@endpush