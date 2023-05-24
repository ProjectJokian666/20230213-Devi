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
						<h5>Detail Kejadian Bencana {{$data['wilayah']->bencana->nama_bencana}} di Wilayah {{$data['wilayah']->wilayah->nama_wilayah}}</h5>
						<div>
							<a href="{{url('petugas/data')}}" class="btn btn-sm btn-info text-white">KEMBALI</a>
							<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_data">TAMBAH DATA</button>
							@include('petugas.data.create')
							@include('petugas.data.update')
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center" id="tbl_detail">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Tanggal</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
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
<script type="text/javascript">
	show_data()
	// console.log("{{$data['wilayah']->id_bencana_per_wilayah}}")
	function show_data() {
		$.ajax({
			url:"{{route('petugas.data.get_detail')}}",
			type:"GET",
			data:{
				wilayah:{{$data['wilayah']->id_bencana_per_wilayah}},
			},
			success:function(data){
				// console.log(data.data)
				let baris = 1
				// const data_detail = data.data
				$('#tbl_detail tbody').empty()
				data.data.forEach(function(data){
					// console.log(data.tgl_terjadi,new Date(data.tgl_terjadi))
					const date = new Date(data.tgl_terjadi)
					const options = {year:'numeric',month:'long',day:'numeric'}
					// console.log(date)
					const dateTime = date.toLocaleString('id-ID',options);
					// console.log(date,date.getDate(),dateTime)
					let data_tgl = data.tgl.split('-')
					// console.log(data_tgl)
					var	html = "<tr>"+
					"<td>"+baris+"</td>"+
					"<td>"+dateTime+"</td>"+
					"<td>"+data.jumlah+"</td>"+
					"<td>"+
					"<button class='btn btn-sm btn-info text-white' onclick='ubah("+data.id+","+data_tgl[0]+","+data_tgl[1]+","+data_tgl[2]+","+data.jumlah+")' >UBAH DATA</button>"+
					"<button class='btn btn-sm btn-danger' onclick='hapus("+data.id+","+data_tgl[0]+","+data_tgl[1]+","+data_tgl[2]+","+data.jumlah+")' >HAPUS DATA</button>"+
					"</td>"+
					"</tr>"
					$('tbody').append(html)
					baris+=1
				})

			},
			error:function(data){
				console.log(data)
			}
		})
	}
	let tgl_for_update
	let jumlah_for_update
	function ubah(id,tahun,bulan,tgl,jumlah) {
		$('#update_data').modal('show')
		let data_bulan = String(bulan).padStart(2,"0")
		let data_tgl = String(tgl).padStart(2,"0")
		let data_date = tahun+"-"+data_bulan+"-"+data_tgl
		$('#update_tanggal').val(data_date)
		$('#update_jumlah').val(jumlah)
		
		$.ajax({
			url:"{{route('petugas.data.data.get_detail')}}",
			type:"GET",
			data:{
				'id':id,
				'tgl':data_date,
				'jumlah':jumlah,
			},
			success:function(data){
				const date = new Date(data.data.tgl_terjadi)
				const options = {year:'numeric',month:'long',day:'numeric'}
				const dateTime = date.toLocaleString('id-ID',options);

				// console.log(data,data.data.tgl_terjadi,dateTime,$('#tgl_update').text())
				$('#tgl_update').text("Update Tanggal "+dateTime)
				tgl_for_update=data.data.tgl_terjadi
				jumlah_for_update=data.data.jumlah
				// console.log(tgl_for_update,jumlah_for_update)
			},
			error:function(data){
				console.log(data)
			}
		});

		// console.log(tahun+"-"+bulan+"-"+tgl)
		// console.log(id,tahun,bulan,tgl,jumlah)
	}

	function hapus(id,tahun,bulan,tgl,jumlah) {
		$.ajax({
			url:"{{route('petugas.data.delete_detail')}}",
			type:"DELETE",
			data:{
				'_token':"{{csrf_token()}}",
				id:id,
				tgl:tahun+"-"+bulan+"-"+tgl,
				jumlah:jumlah,
			},
			success:function(data){
				show_data()
				// console.log(data)
			},
			error:function(data){
				console.log(data)
			}
		})
		// console.log(id,tahun,bulan,tgl,jumlah)
	}
</script>
@endpush