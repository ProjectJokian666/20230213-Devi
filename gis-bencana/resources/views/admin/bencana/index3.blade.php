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
								<th scope="col">No.</th>
								<th scope="col">Nama Bencana</th>
								<th scope="col">Wilayah</th>
								<th scope="col">Terdampak ( % )</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							?>
							@foreach($data['bencana'] as $key => $value)
							@if($value->bencanaperwilayah->count())
							@foreach($value->bencanaperwilayah as $key_wilayah => $value_wilayah)
							<tr>
								<td><?= $no++; ?></td>
								<td>{{$value->nama_bencana}}</td>
								<td></td>
								<td></td>
								<td>
									<a href="{{url('admin/bencana/wilayah',$value_wilayah['id_bencana_per_wilayah'])}}" class="btn btn-sm btn-info text-white">DETAIL</a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td><?= $no++; ?></td>
								<td>{{$value->nama_bencana}}</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							@endif
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