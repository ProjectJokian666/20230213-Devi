@extends('layouts.app')

@push('csss')
@endpush

@section('content')
<section class="section dashboard">
	<div class="row">
		@foreach($data['bencana'] as $bencana)
		<div class="col-4">
			<div class="card info-card">
				<div class="card-body">
					<h5 class="card-title">{{$bencana->nama_bencana}}</h5>
					<div class="d-flex align-items-center">
						<div class="ps-3">
							<span class="text-success small pt-1 fw-bold">
								{{$bencana->deskripsi_bencana}}
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</section>
@endsection
@push('jss')

@endpush