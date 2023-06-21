<script type="text/javascript">
	let data_wilayah="";
	let a = 0;

	let filter_bencana = "";
	let filter_wilayah = "";
	let filter_tahun = "";
	
	$('#filter_button').on('click',function(){
		filter_bencana = $('#filter_bencana').val()
		filter_wilayah = $('#filter_wilayah').val()
		filter_tahun = $('#filter_tahun').val()

		// console.log(a+=1,filter_bencana,filter_wilayah,filter_tahun);
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

	map.addControl(new mapboxgl.NavigationControl());
	map.addControl(new mapboxgl.FullscreenControl());

	var hoveredStateId = null;

	show_peta()
	function show_peta(){

		if (map.getSource('data_source')) {
			map.removeLayer('outline')
			map.removeLayer('fill_isi')
			map.removeSource('data_source');

			$.ajax({
				url:"{{route('get_maps_fix')}}",
				type:"GET",
				data:{
					filter_bencana : filter_bencana,
					filter_wilayah : filter_wilayah,
					filter_tahun : filter_tahun,
				},
				success:function(data){
					// console.log(data,filter_bencana,filter_wilayah,filter_tahun);
					data_wilayah = data.wilayah;
					data_wilayah = JSON.parse('['+data_wilayah+']');
					map.addSource('data_source',{
						'type':'geojson',
						'data':{
							'type':'FeatureCollection',
							'features':data_wilayah
						},
					});
					map.addLayer({
						'id': 'fill_isi',
						'type': 'fill',
						'source': 'data_source',
						'layout': {},
						'paint': {
							'fill-color': [
								"case",
								['<', ['get', "data_bencana"], 0], "#c8d1e1",
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
				},
				error:function(data){
					console.log(data);
				}
			});

		}
		else{
			filter_bencana = $('#filter_bencana').val()
			filter_wilayah = $('#filter_wilayah').val()
			filter_tahun = $('#filter_tahun').val()
			map.on('load',function(){
				$.ajax({
					url:"{{route('get_maps_fix')}}",
					type:"GET",
					data:{
						filter_bencana : filter_bencana,
						filter_wilayah : filter_wilayah,
						filter_tahun : filter_tahun,
					},
					success:function(data){
						// console.log(data);
						data_wilayah = data.wilayah;
						data_wilayah = JSON.parse('['+data_wilayah+']');
						map.addSource('data_source',{
							'type':'geojson',
							'data':{
								'type':'FeatureCollection',
								'features':data_wilayah
							},
						});
						map.addLayer({
							'id': 'fill_isi',
							'type': 'fill',
							'source': 'data_source',
							'layout': {},
							'paint': {
								'fill-color': [
									"case",
									['<', ['get', "data_bencana"], 0], "#c8d1e1",
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
										'<h6><b> Terdampak '+feature.properties.terdampak+' Jiwa </b></h6>'+
										'<h6><b> Persentase '+feature.properties.data_bencana+' %</b></h6>'+
										'</p>'
										)
									.addTo(map);
									map.setFeatureState({
										source:'data_source',
										id:hoveredStateId
									},{
										hover:false
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
					},
					error:function(data){
						console.log(data);
					}
				})
			})
		}
	}
</script>