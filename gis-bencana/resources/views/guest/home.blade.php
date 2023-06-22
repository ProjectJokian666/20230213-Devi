@extends('layouts.app')

@push('csss')
<link href="{{asset('mapbox/mapbox-gl.css')}}" rel="stylesheet">
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<!-- <div class="col-12 mt-3 mb-3">
			<div class="row">
				<div class="col-3">
					<select class="form-control" id="bencana" name="bencana">
						@foreach($data['bencana'] as $key => $value)
						<option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="tanggal1" name="tanggal1">
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="tanggal2" name="tanggal2">
				</div>
				<div class="col-3">
					<button type="button" class="btn btn-primary" id="btn_lihat">Lihat</button>
				</div>
			</div>
		</div> -->
		<div class="col-12 mt-3 mb-3">
			<div class="row">
				<div class="col-3">
					<div class="row">
						<div class="col-12">
							<label>Bencana</label>
						</div>
						<div class="col-12">
							<select name="filter_bencana" class="form-control" id="filter_bencana">
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
							<select name="filter_wilayah" class="form-control" id="filter_wilayah">
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
							<select name="filter_tahun" class="form-control" id="filter_tahun">
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
		</div>
		<div id="maps" style="height:500px;">
			@include('layouts.keterangan')
		</div>
	</div>
</section>
@endsection

@push('jss')
<script src="{{asset('mapbox/mapbox-gl.js')}}"></script>
<script>
	show_wilayah()
	$('#filter_bencana').on('change',function(){
		show_wilayah()
	})
	$('#filter_wilayah').on('change',function(){
		show_tahun()
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
					
				}
			},
			error:function(data){
				console.log(data)
			}
		})
	}
</script>
@include('guest.mapsfix')
@endpush