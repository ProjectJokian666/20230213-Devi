<script type="text/javascript">
	let data_wilayah="";
	let a = 0;
	let bencana = "";
	let tanggal1 = "";
	let tanggal2 = "";
	$('#btn_lihat').on('click',function(){
		// console.log(a+=1);
		bencana = $('#bencana').val()
		tanggal1 = $('#tanggal1').val()
		tanggal2 = $('#tanggal2').val()
		// console.log(bencana);
		// console.log(tanggal1);
		// console.log(tanggal2);

		show_peta()
	});

	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
	const map = new mapboxgl.Map(
	{
		container: 'maps',
		style: 'mapbox://styles/mapbox/{{env("MAPBOX_STYLE")}}',
		center: [112.03, -7.824],
		zoom: 11.5,
	});

	var hoveredStateId = null;

	show_peta()
	function show_peta(){
		// console.log('load_peta')
		if (map.getSource('data_source')) {
			map.removeLayer('outline')
			map.removeLayer('fill_isi')
			map.removeSource('data_source');
			// console.log('masuk if')
			// map.removeLayer('outline')
			// map.removeLayer('maine')
			// map.removeSource('data_source');

			// console.log(bencana);
			// console.log(tanggal1);
			// console.log(tanggal2);
			$.ajax({
				url:"{{route('admin.get_maps')}}",
				type:"GET",
				data:{
					bencana : bencana,
					tanggal1 : tanggal1,
					tanggal2 : tanggal2,
				},
				success:function(data){
					data_wilayah = data.wilayah;
					data_wilayah = JSON.parse('['+data_wilayah+']');

					// console.log('sudah json',data.wilayah)

					map.addSource('data_source',{
						'type':'geojson',
						'data':{
							'type':'FeatureCollection',
							'features':data_wilayah
						},
					});
					// console.log('tidak',data_wilayah)
					
					map.addLayer({
						'id': 'fill_isi',
						'type': 'fill',
						'source': 'data_source',
						'layout': {},
						'paint': {
							'fill-color': [
								"case",
								['<=', ['get', "data_bencana"], 0], "#c8d1e1",
								['<=', ['get', "data_bencana"], 29], "#5cfc00",
								['<=', ['get', "data_bencana"], 59], "#fc7600",
								['<=', ['get', "data_bencana"], 100], "#360602",
								'#123456'
								],
							'fill-opacity': [
								'case',
								['boolean', ['feature-state', 'hover'], false],
								1,
								0.5
								]
						}
					});
					map.addLayer({
						'id': 'outline',
						'type': 'line',
						'source': 'data_source',
						'layout': {},
						'paint': {
							'line-color': '#c3ccbe',
							'line-width': 3
						}
					});



					// data_wilayah = JSON.parse(data_wilayah);
				},
				error:function(data){
					console.log(data);
				}
			});

		}
		else{
			map.on('load',()=>{
				// console.log('load maps');
				map.addSource('data_source', {
					'type': 'geojson',
					'data': {
						'type': 'FeatureCollection',
						'features': [
							<?php

							use App\Models\Bencana;
							use App\Models\BencanaPerWilayah;
							use App\Models\DataBencanaPerWilayah;

							// menampilkan data wilayah 
							$a = 0;
							foreach ($data['wilayah'] as $key => $value_wilayah) {
								echo '{';
								echo '"id":"'.$value_wilayah['id'].'",';
								echo '"properties":{';
								echo '"nama":"'.$value_wilayah['nama_wilayah'].'",';
								echo '"data_bencana":'.$a.',';
								echo '},';
								echo file_get_contents("Data_Wilayah/".$value_wilayah['file_wilayah']);
								echo "},";
								$a = $a+10;

							}
							?>
							]
					}
				});
				map.addLayer({
					'id': 'fill_isi',
					'type': 'fill',
					'source': 'data_source',
					'layout': {},
					'paint': {
						'fill-color': [
							"case",
							['<=', ['get', "data_bencana"], 0], "#c8d1e1",
							['<=', ['get', "data_bencana"], 29], "#5cfc00",
							['<=', ['get', "data_bencana"], 59], "#fc7600",
							['<=', ['get', "data_bencana"], 100], "#360602",
							'#123456'
							],
						'fill-opacity': [
							'case',
							['boolean', ['feature-state', 'hover'], false],
							1,
							0.5
							]
					}
				});
				map.addLayer({
					'id': 'outline',
					'type': 'line',
					'source': 'data_source',
					'layout': {},
					'paint': {
						'line-color': '#c3ccbe',
						'line-width': 3
					}
				});

				var popup = new mapboxgl.Popup({
					closeButton: false,
					closeOnClick: false
				});

				map.on('mousemove','fill_isi',function(e){
					if (e.features.length>0) {
						// console.log('hahah111');
						if (hoveredStateId) {
							// console.log('masuk if');
							map.getCanvas().style.cursor = 'pointer';
							var feature = e.features[0];
							// console.log('masuk');
							popup.setLngLat(e.lngLat)
							.setHTML(
								'<p class"text-center">'+
								'<h6><b>'+feature.properties.nama+'</b></h6>'+
								'<h6><b>'+feature.properties.data_bencana+'</b></h6>'+
								'</p>'
								)
							.addTo(map);
							map.setFeatureState({
								source:'data_source',
								id:hoveredStateId
							},{
								hover:true
							});
						}
						hoveredStateId = e.features[0].id;
						map.setFeatureState({
							source: 'data_source',
							id: hoveredStateId
						}, {
							hover: true
						});
					}
				})

				map.on('mouseleave', 'fill_isi', function() {
					if (hoveredStateId) {
						map.getCanvas().style.cursor = '';
						popup.remove();
						map.setFeatureState({
							source: 'data_source',
							id: hoveredStateId
						}, {
							hover: false
						});
					}
					hoveredStateId = null;
				});

				map.on('idle', function() {
					map.resize()
				});
			})
		}
	}
</script>