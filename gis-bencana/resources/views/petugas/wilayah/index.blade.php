@extends('layouts.app')
@push('csss')
<link rel="stylesheet" href="{{asset('Simple-DataTables-classic-master')}}/src/style.css">
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
						<h5>Tabel Wilayah</h5>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center" style="font-size: 10pt;">
						<thead>
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Wilayah</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['wilayah'] as $wilayah)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$wilayah->nama_wilayah}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#update_wilayah_{{$wilayah->id}}"><i class="bi bi-pencil"></i></button>
									<button type="button" class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#delete_wilayah_{{$wilayah->id}}"><i class="bi bi-trash"></i></button>
									@include('petugas.wilayah.update')
									@include('petugas.wilayah.delete')
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Default Table Example -->
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('jss')
<script src="{{asset('Simple-DataTables-classic-master')}}/simple-datatables-classic@latest.js"></script>
<script type="text/javascript">
	var table = new simpleDatatables.DataTable("table");
</script>
@endpush