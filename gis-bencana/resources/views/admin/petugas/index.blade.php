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
						<h5>Tabel Petugas</h5>
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_petugas"><i class="bi bi-plus"></i></button>
						@include('admin.petugas.create')
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center table-striped table-bordered" style="font-size: 10pt;">
						<thead>
							<tr>
								<th scope="col" class="text-center">No.</th>
								<th scope="col" class="text-center">Nama</th>
								<th scope="col" class="text-center">Email</th>
								<th scope="col" class="text-center">Level</th>
								<th scope="col" class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['user'] as $user)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>{{$user->role}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#update_petugas_{{$user->id}}"><i class="bi bi-pencil"></i></button>
									@include('admin.petugas.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_petugas_{{$user->id}}"><i class="bi bi-trash"></i></button>
									@include('admin.petugas.delete')
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