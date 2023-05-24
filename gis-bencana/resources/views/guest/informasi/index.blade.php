@extends('layouts.app')

@push('csss')
<!-- DataTable Styles -->
<link rel="stylesheet" href="{{asset('Simple-DataTables-classic-master')}}/src/style.css">

<!-- Demo Styles -->
<!-- <link rel="stylesheet" href="{{asset('Simple-DataTables-classic-master')}}/docs/demo.css"> -->
@endpush

@section('content')
<section class="section dashboard">
	<div class="row">
		<!-- <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xl-4">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">Gempa Bumi Terbaru</h5>
					<div class="ps-3">
						<span class="text-success small pt-1 fw-bold">
							Data Gempa Terkini
						</span>
					</div>
					<div class="ps-3">
						<span class="text-success small pt-1 fw-bold">
							Koordinat
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xl-4">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">Gempa Bumi Terkini</h5>
					<div class="d-flex align-items-center">
						<div class="ps-3">
							<span class="text-success small pt-1 fw-bold">
								xx
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xl-4">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">Gempa Bumi Dirasakan</h5>
					<div class="d-flex align-items-center">
						<div class="ps-3">
							<span class="text-success small pt-1 fw-bold">
								xx
							</span>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		@foreach($data['bencana'] as $bencana)
		<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xl-3">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">{{$bencana->nama_bencana}}</h5>
					<div class="d-flex align-items-center">
						<div class="ps-3">
							<span class="text-success small pt-1 fw-bold">
								<?=
								strlen($bencana->deskripsi_bencana)==0
								?
								"kosong"
								:
								(
									strlen($bencana->deskripsi_bencana)>=10
									?
									substr($bencana->deskripsi_bencana,0,10).' ... '.'<a type="button" data-bs-toggle="modal" data-bs-target="#bencana-'.$bencana->id.'">Read More</a>'
									:
									$bencana->deskripsi_bencana
								)
								?>
								&nbsp;
								&nbsp;
								&nbsp;
								
								<div class="modal fade" id="bencana-{{$bencana->id}}" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">{{$bencana->nama_bencana}}</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												{{$bencana->deskripsi_bencana}}
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xl-12">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">Gempa Bumi Dirasakan</h5>
					<table class="table datatable table-sm">
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Waktu Gempa</th>
								<th scope="col">Lintang - Bujur</th>
								<th scope="col">Magnitudo</th>
								<th scope="col">Kedalaman</th>
								<th scope="col">Dirasakan (SKALA MMI)</th>
							</tr>
						</thead>
						<tbody>
							@if($data['status']=='sukses')
							@foreach($data['gempa_dirasakan'] as $key => $value)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$value->Tanggal}}<br>{{$value->Jam}}</td>
								<td>{{$value->Lintang}}{{$value->Bujur}}</td>
								<td>{{$value->Magnitude}}</td>
								<td>{{$value->Kedalaman}}</td>
								<td>
									<?php 
									$dirasakan = explode(",",$value->Dirasakan);
									// var_dump($dirasakan);
									foreach ($dirasakan as $key_di => $value_di) {
										echo $value_di."<br>";
									}
									?>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('jss')
@include('guest.informasi.auto_gempa')
<script src="{{asset('Simple-DataTables-classic-master')}}/simple-datatables-classic@latest.js"></script>
<script type="text/javascript">
	var table = new simpleDatatables.DataTable("table");
</script>
@endpush