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
						<h5>Tabel Bencana</h5>
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_petugas">TAMBAH DATA</button>
						@include('admin.bencana.create')
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center">
						<thead>
							<tr>
								<th scope="col" class="text-center">No.</th>
								<th scope="col" class="text-center">Nama Bencana</th>
								<th scope="col" class="text-center">Deskripsi Bencana</th>
								<th scope="col" class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['bencana'] as $key => $value)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$value['nama_bencana']}}</td>
								<td>
									@if(strlen($value['deskripsi_bencana'])>=20)
									{{substr($value['deskripsi_bencana'],0,20)}}...
									@else
									{{$value['deskripsi_bencana']}}
									@endif
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#update_petugas_{{$value['id']}}">UBAH DATA</button>
									@include('admin.bencana.update')
									<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_petugas_{{$value['id']}}">HAPUS DATA</button>
									@include('admin.bencana.delete')
									<!-- <a href="{{url('admin/bencana/wilayah',$value['id'])}}" class="btn btn-sm btn-success">WILAYAH</a> -->
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