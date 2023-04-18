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
						<h5>Tabel Bencana</h5>
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_petugas">TAMBAH DATA</button>
						@include('admin.bencana.create')
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nama</th>
								<th scope="col">Deskripsi</th>
								<th scope="col">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['bencana'] as $bencana)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$bencana->nama_bencana}}</td>
								<td>{{substr($bencana->deskripsi_bencana,0,30)}} ...</td>
								<td>
									<button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#update_petugas_{{$bencana->id}}">UBAH DATA</button>
									@include('admin.bencana.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_petugas_{{$bencana->id}}">HAPUS DATA</button>
									@include('admin.bencana.delete')
									<a href="{{url('admin/bencana/wilayah',$bencana->id)}}" class="btn btn-sm btn-success">WILAYAH</a>
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