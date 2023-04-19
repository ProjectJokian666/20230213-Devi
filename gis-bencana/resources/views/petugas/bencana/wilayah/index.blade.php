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
							<a href="{{url('petugas/bencana')}}" type="button" class="btn btn-sm btn-secondary">KEMBALI</a>
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Wilayah</th>
								<th scope="col">Jumlah Terjadi</th>
								<th scope="col">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['wilayah'] as $w)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$w->wilayah->nama_wilayah}}</td>
								<td>
									<?php 
									$count = 0;
									foreach($w->data_per_wilayah as $dpw){
										$count+=$dpw->jumlah;
									}
									echo $count;
									?>
								</td>
								<td>
									<form action="{{url('petugas/bencana/wilayah',$w->id_bencana)}}" method="POST">
										@csrf
										<button type="submit" name="wilayah" value="{{$w->id_wilayah}}" class="btn btn-sm btn-info text-white">LIHAT DATA</button>
									</form>
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