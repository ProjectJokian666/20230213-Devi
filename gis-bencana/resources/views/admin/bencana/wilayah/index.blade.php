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
						<h5>Tabel Wilayah {{$data['bencana']->nama_bencana}}</h5>
						<div>
							<a href="{{url('admin/bencana')}}" type="button" class="btn btn-sm btn-secondary">KEMBALI</a>
							<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_data_per_wilayah">TAMBAH DATA</button>
						</div>
						@include('admin.bencana.wilayah.create')
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Wilayah</th>
								<th scope="col">Jumlah Terjadi</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['wilayah'] as $w)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$w->wilayah->nama_wilayah}}</td>
								<td>
									{{$w->data_per_wilayah->count()}}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#update_{{$w->id_bencana_per_wilayah}}">UBAH DATA</button>
									@include('admin.bencana.wilayah.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_data_{{$w->id_bencana_per_wilayah}}">HAPUS DATA</button>
									@include('admin.bencana.wilayah.delete')
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