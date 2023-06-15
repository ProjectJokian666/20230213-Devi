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
						<h5>Tabel Rekap</h5>
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_data"><i class="bi bi-plus"></i></button>
						@include('petugas.data.create')
						@include('petugas.data.update')
					</div>
					<div class="col-12 row">
						<div class="col-3">
							<select name="filter_bencana" class="form-control" id="filter_bencana">
								@foreach($data['bencana'] as $key => $value)
								<option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-3" id="show_filter_wilayah">
							<select name="filter_wilayah" class="form-control" id="filter_wilayah">
							</select>
						</div>
						<div class="col-3" id="show_filter_tahun">
							<select name="filter_tahun" class="form-control" id="filter_tahun">
							</select>
						</div>
						<div class="col-3" id="show_filter_button">
							<button id="show_filter_button" class="btn btn-info text-white"><i class="bi bi-eye"></i></button>
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center" id="data_rekap">
						<thead>
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Bulan</th>
								<th class="text-center">Tahun</th>
								<th class="text-center">Nama Bencana</th>
								<th class="text-center">Wilayah</th>
								<th class="text-center">Terdampak</th>
								<th class="text-center">Deskripsi</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<!-- @foreach($data['data'] as $key => $value)
							<tr>
								<td>
									{{$loop->iteration}}
								</td>
								<td>
									{{ DATE('d',strtotime($value->tgl_terjadi)) }}
								</td>
								<td>
									<?php 
									$arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
									?>
									{{
										$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1]
									}}
								</td>
								<td>
									{{ DATE('Y',strtotime($value->tgl_terjadi)) }}
								</td>
								<td>
									{{ $value->nama_bencana($value->per_wilayah->id_bencana)->nama_bencana }}
								</td>
								<td>
									{{ $value->nama_wilayah($value->per_wilayah->id_wilayah)->nama_wilayah }}
								</td>
								<td>
									{{ $value->jumlah }} jiwa
								</td>
								<td>
									{{ substr($value->deskripsi,0,10) }}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-warning" onclick="ubah('{{$value->tgl_terjadi}}','{{$value->id_bencana_per_wilayah}}','{{$value->jumlah}}','{{$value->deskripsi}}','{{DATE('d M Y',strtotime($value->tgl_terjadi))}}')"><i class="bi bi-pencil"></i></button>
									<button type="button" class="btn btn-sm btn-danger" onclick="hapus('{{$value->tgl_terjadi}}','{{$value->id_bencana_per_wilayah}}')"><i class="bi bi-trash"></i></button>
								</td>
							</tr>
							@endforeach -->
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

	function hapus(tgl,id) {
		$.ajax({
			url:"{{route('petugas.data.delete_wilayah_by_id')}}",
			type:"DELETE",
			data:{
				'_token':"{{csrf_token()}}",
				id:id,
				tgl:tgl,
			},
			success:function(data){
				location.reload(true)
				// show_data()
				// console.log(data)
			},
			error:function(data){
				console.log(data)
			}
		})
	}

	function ubah(tgl,id,jml,desk,judul) {
		$('#update_id').val(jml)
		$('#tgl_update').html(judul)
		$('#update_tanggal').val(tgl)
		$('#update_jumlah').val(jml)
		$('#update_deskripsi').val(desk)
		$('#update').modal('show')
		// console.log(tgl,id,jml,desk)
	}

	// show_filter_bencana()
	$('#filter_bencana').on('change',function() {
		show_filter_bencana()
	})
	function show_filter_bencana(){
		// console.log('aa')
		$.ajax({
			url:"{{route('petugas.data.wilayah_by_id')}}",
			type:"GET",
			data:{
				id:$('#filter_bencana').val(),
			},
			success:function(data) {
				// console.log(data.wilayah)
				$('#filter_wilayah').empty()
				$('#show_filter_wilayah').hide();
				$('#show_filter_tahun').hide();

				const id_data_wilayah = [];
				const nama_data_wilayah = [];
				// const data_tanggal = [];
				$('#filter_wilayah').empty()
				data.wilayah.forEach(function(data) {
					$('#show_filter_wilayah').show();
					var option="<option value='"+data.id_bencana_per_wilayah+"'>"+data.nama_wilayah+"</option>"
					$('#filter_wilayah').append(option);
				})
				show_filter_wilayah()

			},
			error:function(data){
				console.log(data)
			}
		})
	}
	$('#filter_wilayah').on('change',function() {
		show_filter_wilayah()
	})
	function show_filter_wilayah() {
		$.ajax({
			url:"{{route('petugas.data.tahun_by_id')}}",
			type:"GET",
			data:{
				id:$('#filter_wilayah').val(),
			},
			success:function(data) {
				// console.log(data)
				$('#show_filter_tahun').hide()
				// const data_tahun = []
				$('#filter_tahun').empty()
				data.tahun.forEach(function(data) {
					$('#show_filter_tahun').show()
					split_tahun = data.tgl_terjadi.split('-')
					var option="<option value='"+split_tahun[0]+"'>"+split_tahun[0]+"</option>"
					$('#filter_tahun').append(option);
					// if (data_tahun.indexOf(split_tahun[0])==-1) {
						// data_tahun.push(split_tahun[0])
					// }
					// console.log(data.tgl_terjadi)
				})
				show_data()
				// console.log(data_tahun)
			},
			error:function(data){
				console.log(data)
			}
		})
	}
	// show_data()
	$('#show_filter_button').on('click',function(){
		show_data()
	})
	function show_data() {
		if () {
			
		}
		else if(){
			
		}
		else if(){
			
		}

		// console.log('reload data')
		$.ajax({
			url:"{{route('petugas.data.show_data')}}",
			type:"GET",
			data:{
				bencana:$('#filter_bencana').val(),
				wilayah:$('#filter_wilayah').val(),
				tahun:$('#filter_tahun').val(),
			},
			success:function(data) {
				console.log(data)
				let baris = 1
				$('#data_rekap tbody').empty()
				data.data.forEach(function(data){
					var html = "<tr>"+
					"<td>"+baris+"</td>"+
					"<td>"+data.tanggal+"</td>"+
					"<td>"+data.bulan+"</td>"+
					"<td>"+data.tahun+"</td>"+
					"<td>"+data.nama_bencana+"</td>"+
					"<td>"+data.wilayah+"</td>"+
					"<td>"+data.terdampak+"</td>"+
					"<td>"+data.deskripsi+"</td>"+
					"</tr>"
					$('tbody').append(html)
					baris+=1;
					// console.log(data)
				})
			},
			error:function(data) {
				console.log(data)
			}

		})
	}
</script>
@endpush