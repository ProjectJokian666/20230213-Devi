@extends('layouts.app')

@push('csss')
<script src="{{asset('high-chart/highcharts.js')}}"></script>
<script src="{{asset('high-chart/data.js')}}"></script>
<script src="{{asset('high-chart/drilldown.js')}}"></script>
@endpush

@section('content')
<section class="section dashboard">
	<div class="row justify-content-center card">
		<div class="col-12 mt-3">
			<div class="row">
				<div class="col-4">
					<input type="date" class="form-control" id="tanggal1" name="tanggal1">
				</div>
				<div class="col-4">
					<input type="date" class="form-control" id="tanggal2" name="tanggal2">
				</div>
				<div class="col-2">
					<button type="button" class="btn btn-info text-white" id="btn_lihat"><i class="bi bi-eye"></i></button>
				</div>
			</div>
		</div>
		<div class="col-12 mt-3">
			<div id="container" style="height:500px;width: 100%;"></div>
		</div>
	</div>
</section>
@endsection

@push('jss')
<script>
// Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

	var Bencana
	var Rinci

	Get_Data_Grafik()

	$("#btn_lihat").on('click',function() {
		Get_Data_Grafik()
	})

	function Get_Data_Grafik(){
		$.ajax({
			url:"{{route('grafik.get_grafik')}}",
			type:"GET",
			data : {
				tanggal1 : $("#tanggal1").val(),
				tanggal2 : $("#tanggal2").val(),
			},
			success:function(data){
				// Bencana = $("#tanggal").val()
				// Rinci = data
				// console.log(Bencana,Rinci,data,data.Bencana,data.Rinci)
				// Bencana = data.Bencana
				// console.log(Bencana)
				// Rinci = data.Rinci
				// console.log(Rinci)
				// console.log($("#tanggal").val())
				Show_Grafik(data.Bencana,data.Rinci)
			}
		});
	}

	function Show_Grafik(a,b){
		// console.log(a,b)
		// Create the chart
		Highcharts.chart('container', {
			chart: {
				type: 'column'
			},
			title: {
				align: 'center',
				text: 'REKAP DATA BENCANA '
			},
			subtitle: {
				align: 'left',
				text: ''
			},
			accessibility: {
				announceNewData: {
					enabled: false
				}
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Jumlah Terjadi'
				}

			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y:.0f} terjadi'
					}
				}
			},

			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Terjadi<br/>'
			},

			series: [
			{
				name: 'BENCANA',
				colorByPoint: true,
				data: a
			}
			],
			drilldown: {
				breadcrumbs: {
					position: {
						align: 'right'
					}
				},
				series:b
		// series: [
		// {
		// 	name: 'Chrome',
		// 	id: 'Chrome',
		// 	data: [
		// 		[
		// 			'v65.0',
		// 			0.1
		// 			],
		// 		[
		// 			'v64.0',
		// 			1.3
		// 			],
		// 		[
		// 			'v63.0',
		// 			53.02
		// 			],
		// 		[
		// 			'v62.0',
		// 			1.4
		// 			],
		// 		[
		// 			'v61.0',
		// 			0.88
		// 			],
		// 		[
		// 			'v60.0',
		// 			0.56
		// 			],
		// 		[
		// 			'v59.0',
		// 			0.45
		// 			],
		// 		[
		// 			'v58.0',
		// 			0.49
		// 			],
		// 		[
		// 			'v57.0',
		// 			0.32
		// 			],
		// 		[
		// 			'v56.0',
		// 			0.29
		// 			],
		// 		[
		// 			'v55.0',
		// 			0.79
		// 			],
		// 		[
		// 			'v54.0',
		// 			0.18
		// 			],
		// 		[
		// 			'v51.0',
		// 			0.13
		// 			],
		// 		[
		// 			'v49.0',
		// 			2.16
		// 			],
		// 		[
		// 			'v48.0',
		// 			0.13
		// 			],
		// 		[
		// 			'v47.0',
		// 			0.11
		// 			],
		// 		[
		// 			'v43.0',
		// 			0.17
		// 			],
		// 		[
		// 			'v29.0',
		// 			0.26
		// 			]
		// 		]
		// },
		// {
		// 	name: 'Firefox',
		// 	id: 'Firefox',
		// 	data: [
		// 		[
		// 			'v58.0',
		// 			1.02
		// 			],
		// 		[
		// 			'v57.0',
		// 			7.36
		// 			],
		// 		[
		// 			'v56.0',
		// 			0.35
		// 			],
		// 		[
		// 			'v55.0',
		// 			0.11
		// 			],
		// 		[
		// 			'v54.0',
		// 			0.1
		// 			],
		// 		[
		// 			'v52.0',
		// 			0.95
		// 			],
		// 		[
		// 			'v51.0',
		// 			0.15
		// 			],
		// 		[
		// 			'v50.0',
		// 			0.1
		// 			],
		// 		[
		// 			'v48.0',
		// 			0.31
		// 			],
		// 		[
		// 			'v47.0',
		// 			0.12
		// 			]
		// 		]
		// },
		// {
		// 	name: 'Internet Explorer',
		// 	id: 'Internet Explorer',
		// 	data: [
		// 		[
		// 			'v11.0',
		// 			6.2
		// 			],
		// 		[
		// 			'v10.0',
		// 			0.29
		// 			],
		// 		[
		// 			'v9.0',
		// 			0.27
		// 			],
		// 		[
		// 			'v8.0',
		// 			0.47
		// 			]
		// 		]
		// },
		// {
		// 	name: 'Safari',
		// 	id: 'Safari',
		// 	data: [
		// 		[
		// 			'v11.0',
		// 			3.39
		// 			],
		// 		[
		// 			'v10.1',
		// 			0.96
		// 			],
		// 		[
		// 			'v10.0',
		// 			0.36
		// 			],
		// 		[
		// 			'v9.1',
		// 			0.54
		// 			],
		// 		[
		// 			'v9.0',
		// 			0.13
		// 			],
		// 		[
		// 			'v5.1',
		// 			0.2
		// 			]
		// 		]
		// },
		// {
		// 	name: 'Edge',
		// 	id: 'Edge',
		// 	data: [
		// 		[
		// 			'v16',
		// 			2.6
		// 			],
		// 		[
		// 			'v15',
		// 			0.92
		// 			],
		// 		[
		// 			'v14',
		// 			0.4
		// 			],
		// 		[
		// 			'v13',
		// 			0.1
		// 			]
		// 		]
		// },
		// {
		// 	name: 'Opera',
		// 	id: 'Opera',
		// 	data: [
		// 		[
		// 			'v50.0',
		// 			0.96
		// 			],
		// 		[
		// 			'v49.0',
		// 			0.82
		// 			],
		// 		[
		// 			'v12.1',
		// 			0.14
		// 			]
		// 		]
		// }
		// ]
			}
		});

	}
</script>
@endpush