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
					<div class="d-flex mt-4 mb-4 justify-content-between row">
						<div class="col-6">
							<select name="bencana" class="form-control" id="bencana">
								@foreach($data['bencana'] as $key => $value)
								<option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-6">
							<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_wilayah"><i class="bi bi-plus"></i></button>
							@include('admin.setwilayahbencana.create')
							@include('admin.setwilayahbencana.update')
						</div>
					</div>
					<!-- Default Table -->
					<table class="table datatable table-sm text-center" id="tbl_wilayah">
						<thead>
							<tr>
								<th scope="col" class="text-center">No.</th>
								<th scope="col" class="text-center">Nama Wilayah</th>
								<th scope="col" class="text-center">Aksi</th>
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

	$('#bencana').on('change',function(){
		show_data()
	})

	function show_data(){
		$.ajax({
			url:"{{route('admin.setwilayahbencana.show_data')}}",
			type:"GET",
			data:{
				bencana : $('#bencana').val(),
			},
			success:function(data){
				// console.log(data.wilayah)
				const data_wilayah = data.wilayah
				// console.log(data_wilayah)
				let baris = 1
				$('#tbl_wilayah tbody').empty()
				data_wilayah.forEach(function(data){
					var html = "<tr>"+
					"<td class='baris'>"+baris+"</td>"+
					"<td class='nama_wilayah'>"+data.nama_wilayah+"</td>"+
					"<td><button class='btn btn-warning btn-sm text-white' onclick='edit("+data.id_wilayah+")' ><i class='bi bi-pencil'></i></button>"+
					"<button class='btn btn-danger btn-sm' onclick='hapus("+data.id_wilayah+")'><i class='bi bi-trash'></i></button>"+
					"</td>"+
					"</tr>"
					$('tbody').append(html)
					baris+=1					
				})
				// each(data.wilayah,function(){
					// console.log(data)
				// });
				//

				const data_wilayah_show = data.wilayah_option
				if (data_wilayah_show.length>0) {
					$('#status_kosong').hide()
					$('#status_ada').show()
					$('#status_update_kosong').hide()
					$('#status_update_ada').show()
				}
				else {
					$('#status_kosong').show()
					$('#status_ada').hide()
					$('#status_update_kosong').show()
					$('#status_update_ada').hide()
				}
				$('#wilayah_option').empty()
				data_wilayah_show.forEach(function(data){
					var option = "<option value="+data.id+">"+data.nama_wilayah+"</option>"
					$('#wilayah_option').append(option)
				})
				$('#wilayah_update').empty()
				data_wilayah_show.forEach(function(data){
					var option = "<option value="+data.id+">"+data.nama_wilayah+"</option>"
					$('#wilayah_update').append(option)
				})
			},
			error:function(data){

			}
		})
	}
	let wil_update=0
	function edit(id){
		wil_update = id
		$('#update_wilayah').modal('show')
		// console.log(id)
	}
	function hapus(id){
		$.ajax({
			url:"{{route('admin.setwilayahbencana.delete_data')}}",
			type:"DELETE",
			data:{
				'_token':"{{csrf_token()}}",
				wilayah : id,
				bencana : $('#bencana').val(),
			},
			success:function(data){
				show_data()
				// console.log(data)
			},
			error:function(data){

			}
		});
		// console.log(id)
	}
</script>
@endpush