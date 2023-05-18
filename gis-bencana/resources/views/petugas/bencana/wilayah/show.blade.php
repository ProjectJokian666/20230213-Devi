@extends('layouts.app')
@push('csss')
<link href="{{asset('NiceAdmin/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
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
						<h5>Tabel Data {{$data['wilayah']->bencana->nama_bencana}} Wilayah {{$data['wilayah']->wilayah->nama_wilayah}}</h5>
						<div>
							<a href="{{url('petugas/bencana/wilayah',$data['wilayah']->id_bencana)}}" type="button" class="btn btn-sm btn-secondary">KEMBALI</a>
							<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_wilayah">TAMBAH DATA</button>
							@include('petugas.bencana.wilayah.add')
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Tanggal</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['bencana'] as $b)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{DATE('d F Y',strtotime($b->tgl_terjadi))}}</td>
								<td>{{$b->jumlah}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#update_wilayah_{{$b->tgl_terjadi}}">UBAH DATA</button>
									@include('petugas.bencana.wilayah.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_wilayah_{{$b->tgl_terjadi}}">HAPUS DATA</button>
									@include('petugas.bencana.wilayah.delete')
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
<script src="{{asset('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
@endpush