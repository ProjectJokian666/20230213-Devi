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
			<div class="card" id="peta_preview">
				<div id="maps" style="height:500px;"></div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('jss')
<script src="{{asset('mapbox/mapbox-gl.js')}}"></script>
@include('admin.wilayah.maps')
@endpush
