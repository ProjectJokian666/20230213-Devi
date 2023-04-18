@extends('layouts.app')
@push('csss')
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
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_petugas">TAMBAH DATA</button>
						@include('admin.petugas.create')
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nama</th>
								<th scope="col">Email</th>
								<th scope="col">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['user'] as $user)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#update_petugas_{{$user->id}}">UBAH DATA</button>
									@include('admin.petugas.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_petugas_{{$user->id}}">HAPUS DATA</button>
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

@endpush