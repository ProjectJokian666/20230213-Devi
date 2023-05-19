<script type="text/javascript">
	let a = 0;
	let bencana = "";
	let tanggal1 = "";
	let tanggal2 = "";
	$('#btn_lihat').on('click',function(){
		console.log(a+=1);
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

	show_peta()
	function show_peta(){
		console.log('load_peta')
		if (map.getSource('data_source')) {
			console.log('masuk if')
			// map.removeLayer('outline')
			// map.removeLayer('maine')
			// map.removeSource('data_source');

			console.log(bencana);
			console.log(tanggal1);
			console.log(tanggal2);

			$.ajax({
				url:"{{route('admin.get_maps')}}",
				type:"GET",
				data:{
					bencana : bencana,
					tanggal1 : tanggal1,
					tanggal2 : tanggal2,
				},
				success:function(data){
					console.log(data);
				},
				error:function(data){
					console.log(data);
				}
			});
		}
		else{
			console.log('masuk else')
			map.on('load',()=>{
				map.addSource('data_source',{
					'type':'geojson',
					'data': {
						'type': 'Feature',
						'geometry': {
							'type': 'Polygon',
							'coordinates': []
						}
					}
				});
				map.addLayer({
					'id': 'maine',
					'type': 'fill',
					'source': 'data_source',
					'layout': {},
					'paint': {
						'fill-color': '#0080ff',
						'fill-opacity': 0.5
					}
				});
				map.addLayer({
					'id': 'outline',
					'type': 'line',
					'source': 'data_source',
					'layout': {},
					'paint': {
						'line-color': '#000',
						'line-width': 3
					}
				});
			})
		}
	}
</script>