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
							<a href="{{url('data')}}" class="btn btn-primary text-white"><i class="ri-loader-3-fill"></i></a>
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center  table-striped table-bordered border-primary" id="data_rekap">
						<thead>
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Nama Bencana</th>
								<th class="text-center">Wilayah</th>
								<th class="text-center">Terdampak</th>
								<th class="text-center">Persentase</th>
								<th class="text-center">Deskripsi</th>
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

	// show_filter_wilayah()
	show_wilayah()
	$('#filter_bencana').on('change',function(){
		show_wilayah()
	})
	function show_wilayah() {
		$('#show_filter_wilayah').hide()
		$('#show_filter_tahun').hide()

		$.ajax({
			url:'{{route('data.wilayah_by_bencana')}}',
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
			url:'{{route('data.tahun_by_wilayah_by_bencana')}}',
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

	$('#filter_wilayah').on('change',function(){
		show_data()
	})
	function show_data() {
		var bencana = $('#filter_bencana').val()
		var wilayah = $('#filter_wilayah').val()
		var tahun = $('#filter_tahun').val()
		let baris = 1
		$('#data_rekap tbody').empty()
		if (bencana!=null&&wilayah==null&&tahun==null) {
			// console.log('a',bencana,wilayah,tahun)
			$.ajax({
				url:"{{route('data.show_wilayah_by_bencana')}}",
				type:"GET",
				data:{
					id_bencana:bencana,
				},
				success:function(data) {
					// console.log(data)
					let baris = 1
					$('#data_rekap tbody').empty()
					data.data.forEach(function(data){
						var data_terdampak = ""
						if (data.deskripsi.length>10) {
							data_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							data_terdampak = data.deskripsi.slice(0,10)
						}
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" jiwa</td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+data_terdampak+"</td>"+
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
				url:"{{route('data.show_tahun_by_wilayah_by_bencana')}}",
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
						var data_terdampak = ""
						if (data.deskripsi.length>10) {
							data_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							data_terdampak = data.deskripsi.slice(0,10)
						}
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" jiwa </td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+data_terdampak+"</td>"+
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
				url:"{{route('data.show_data_tahun_by_wilayah_by_bencana')}}",
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
						var data_terdampak = ""
						if (data.deskripsi.length>10) {
							data_terdampak = data.deskripsi.slice(0,10)+' ...'
						}
						else{
							data_terdampak = data.deskripsi.slice(0,10)
						}
						var html = "<tr>"+
						"<td>"+baris+"</td>"+
						"<td>"+data.tanggal+" "+data.bulan+" "+data.tahun+"</td>"+
						"<td>"+data.nama_bencana+"</td>"+
						"<td>"+data.wilayah+"</td>"+
						"<td>"+data.terdampak+" jiwa</td>"+
						"<td>"+Math.round(data.terdampak/data.pembagi*100)+" %</td>"+
						"<td>"+data_terdampak+"</td>"+
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