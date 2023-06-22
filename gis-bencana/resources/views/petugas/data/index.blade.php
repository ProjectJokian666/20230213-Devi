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
						<h5>Data Terdampak</h5>
						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_data"><i class="bi bi-plus"></i></button>
						@include('petugas.data.create')
						@include('petugas.data.update')
					</div>
					<div class="col-12 row">
						<div class="col-3">
							<div class="row">
								<div class="col-12">
									<label>Bencana</label>
								</div>
								<div class="col-12">
									<select name="filter_bencana" class="form-select" id="filter_bencana">
										@foreach($data['bencana'] as $key => $value)
										<option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-3" id="show_filter_wilayah">
							<div class="row">
								<div class="col-12">
									<label>Wilayah</label>
								</div>
								<div class="col-12">
									<select name="filter_wilayah" class="form-select" id="filter_wilayah">
									</select>
								</div>
							</div>
						</div>
						<div class="col-3" id="show_filter_tahun">
							<div class="row">
								<div class="col-12">
									<label>Tahun</label>
								</div>
								<div class="col-12">
									<select name="filter_tahun" class="form-select" id="filter_tahun">
									</select>
								</div>
							</div>
						</div>
						<div class="col-3" id="show_filter_button">
							<div class="row">
								<div class="col-12">
									<label>Aksi</label>
								</div>
								<div class="col-12">
									<button id="filter_button" class="btn btn-info text-white"><i class="bi bi-eye"></i></button>
									<a href="{{url('/')}}" class="btn btn-primary text-white"><i class="bi bi-arrow-repeat"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center table-bordered border-primary table-striped" id="data_rekap">
						<thead>
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Nama Bencana</th>
								<th class="text-center">Wilayah</th>
								<th class="text-center">Terdampak</th>
								<th class="text-center">Persentase</th>
								<th class="text-center">Deskripsi</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['all_data'] as $key => $value)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td style="text-align: left !important">{{$value['tanggal']}} {{$value['bulan']}} {{$value['tahun']}}</td>
								<td>{{$value['nama_bencana']}}</td>
								<td>{{$value['wilayah']}}</td>
								<td>{{$value['terdampak']}} jiwa</td>
								<td>{{round($value['terdampak']/$value['pembagi']*100,2)}} %</td>
								<td>
									@if(strlen($value['deskripsi'])>=20)
									{{substr($value['deskripsi'],0,20)}}...
									@else
									{{$value['deskripsi']}}
									@endif
								</td>
								<td>
									<div class="row px-2">
										<button type='button' class='btn btn-sm btn-warning col-6' onclick="ubah('{{$value['tgl_terjadi']}}','{{$value['id']}}','{{$value['terdampak']}}','{{$value['deskripsi']}}','{{$value['tanggal']}} {{$value['bulan']}} {{$value['tahun']}}')"><i class='bi bi-pencil'></i></button>
										<button type='button' class='btn btn-sm btn-danger col-6' onclick="hapus('{{$value['tgl_terjadi']}}','{{$value['id']}}','{{$value['terdampak']}}','{{$value['deskripsi']}}','{{$value['tanggal']}} {{$value['bulan']}} {{$value['tahun']}}')"><i class='bi bi-trash'></i></button>
									</div>
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
	var update_tanggal=""
	function hapus(tgl,id,jml,desk,judul) {
		console.log(tgl,id,jml,desk,judul)
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
		// console.log(tgl,id,jml,desk,judul)
		// console.log(tgl)
		$('#update_id').val(id)
		$('#tgl_update').html(judul)
		$('#update_tanggal').val(tgl)
		update_tanggal=tgl
		$('#update_jumlah').val(jml)
		$('#update_deskripsi').val(desk)
		$('#update').modal('show')
		// console.log(tgl,id,jml,desk)
	}

	// show_filter_wilayah()
	show_wilayah()
	$('#filter_bencana').on('change',function(){
		show_wilayah()
	})
	function show_wilayah() {
		$('#show_filter_wilayah').hide()
		$('#show_filter_tahun').hide()

		$.ajax({
			url:'{{route('petugas.data.wilayah_by_bencana')}}',
			type:"GET",
			data:{
				id_bencana:$('#filter_bencana').val(),
			},
			success:function(data) {

				//show data wilayah yang ada di relasi dengan db
				$('#filter_wilayah').empty();
				$('#filter_tahun').empty();
				const kondisi_wilayah = []
				data.data.forEach(function(data) {
					$('#show_filter_wilayah').show()
					if (kondisi_wilayah.indexOf(data.id_wilayah)==-1) {
						kondisi_wilayah.push(data.id_wilayah)
						var option="<option value='"+data.id_wilayah+"'>"+data.nama_wilayah+"</option>"
						$('#filter_wilayah').append(option);
					}
				})
				if (kondisi_wilayah.length>0) {
					show_tahun()
				}
			},
			error:function(data){
				console.log(data)
			}
		})
	}

	$('#filter_wilayah').on('change',function(){
		show_tahun()
	})
	function show_tahun() {
		$.ajax({
			url:'{{route('petugas.data.tahun_by_wilayah_by_bencana')}}',
			type:"GET",
			data:{
				id_bencana:$('#filter_bencana').val(),
				id_wilayah:$('#filter_wilayah').val(),
			},
			success:function(data){
				// console.log(data.data)
				// show data tahun yang ada di relasi dengn db
				$('#filter_tahun').empty();
				const kondisi_tahun = []
				data.data.forEach(function(data){
					$('#show_filter_tahun').show()
					data_tanggal = data.tgl_terjadi.split('-')
					if (kondisi_tahun.indexOf(data_tanggal[0])==-1) {
						kondisi_tahun.push(data_tanggal[0])
						var option="<option value='"+data_tanggal[0]+"'>"+data_tanggal[0]+"</option>"
						$('#filter_tahun').append(option)
					}
				})
				if (kondisi_tahun.length>0) {
					// console.log(kondisi_tahun)
					// show_data()
				}
			},
			error:function(data){
				console.log(data)
			}
		})
	}

	function show_data() {
		var bencana = $('#filter_bencana').val()
		var wilayah = $('#filter_wilayah').val()
		var tahun = $('#filter_tahun').val()
		let baris = 1
		$('#data_rekap tbody').empty()
		if (bencana!=null&&wilayah==null&&tahun==null) {
			// console.log('a',bencana,wilayah,tahun)
			$.ajax({
				url:"{{route('petugas.data.show_wilayah_by_bencana')}}",
				type:"GET",
				data:{
					id_bencana:bencana,
				},
				success:function(data) {
					// console.log(data)
					let baris = 1
					$('#data_rekap tbody').empty()
					data.data.forEach(function(data){
						var tabel_terdampak = ""
						if (data.deskripsi.length>10) {
							tabel_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							tabel_terdampak = data.deskripsi.slice(0,10)
						}
						var data_judul='"'+data.tanggal+" "+data.bulan+" "+data.tahun+'"';
						var data_deskripsi='"'+data.deskripsi+'"';
						var tgl_terjadi='"'+data.tgl_terjadi+'"'
						// console.log(data_judul)
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" orang</td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+tabel_terdampak+"</td>"+
						"<td>"+
						"<button type='button' class='btn btn-sm btn-warning' onclick='ubah("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-pencil'></i></button>"+
						"<button type='button' class='btn btn-sm btn-danger' onclick='hapus("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-trash'></i></button>"+
						"</td>"+
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
		if (bencana!=null&&wilayah!=null&&tahun==null) {
			// console.log('b',bencana,wilayah,tahun)
			$.ajax({
				url:"{{route('petugas.data.show_tahun_by_wilayah_by_bencana')}}",
				type:"GET",
				data:{
					id_bencana:bencana,
					id_wilayah:wilayah,
				},
				success:function(data) {
					// console.log(data)
					let baris = 1
					$('#data_rekap tbody').empty()
					data.data.forEach(function(data){
						var tabel_terdampak = ""
						if (data.deskripsi.length>10) {
							tabel_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							tabel_terdampak = data.deskripsi.slice(0,10)
						}
						var data_judul='"'+data.tanggal+" "+data.bulan+" "+data.tahun+'"';
						var data_deskripsi='"'+data.deskripsi+'"';
						var tgl_terjadi='"'+data.tgl_terjadi+'"'
						// console.log(data_judul)
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" orang</td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+tabel_terdampak+"</td>"+
						"<td>"+
						"<button type='button' class='btn btn-sm btn-warning' onclick='ubah("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-pencil'></i></button>"+
						"<button type='button' class='btn btn-sm btn-danger' onclick='hapus("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-trash'></i></button>"+
						"</td>"+
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
		if (bencana!=null&&wilayah!=null&&tahun!=null) {
			// console.log('c',bencana,wilayah,tahun)
			$.ajax({
				url:"{{route('petugas.data.show_data_tahun_by_wilayah_by_bencana')}}",
				type:"GET",
				data:{
					id_bencana:bencana,
					id_wilayah:wilayah,
					tahun:tahun,
				},
				success:function(data) {
					// console.log(data)
					let baris = 1
					$('#data_rekap tbody').empty()
					data.data.forEach(function(data){
						var tabel_terdampak = ""
						if (data.deskripsi.length>10) {
							tabel_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							tabel_terdampak = data.deskripsi.slice(0,10)
						}
						var data_judul='"'+data.tanggal+" "+data.bulan+" "+data.tahun+'"';
						var data_deskripsi='"'+data.deskripsi+'"';
						var tgl_terjadi='"'+data.tgl_terjadi+'"'
						// console.log(data_judul)
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" orang</td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+tabel_terdampak+"</td>"+
						"<td class='row'>"+
						"<button type='button' class='btn btn-sm btn-warning col-6' onclick='ubah("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-pencil'></i></button>"+
						"<button type='button' class='btn btn-sm btn-danger col-6' onclick='hapus("+tgl_terjadi+","+data.id+","+data.terdampak+","+data_deskripsi+","+data_judul+")'><i class='bi bi-trash'></i></button>"+
						"</td>"+
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
	}

	$('#show_filter_button').on('click',function () {
		show_data()
		// console.log($('#filter_bencana').val(),$('#filter_wilayah').val()==null,$('#filter_tahun').val())
	})

</script>
@endpush