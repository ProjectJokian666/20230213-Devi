<script type="text/javascript">
	// $('#peta_preview').hide();
	let data_peta ="";
	// show_peta();

	$('#file_wilayah').change(function(){
		previewData(this);
	});

	function previewData(input) {

		const data_file = input.files[0];
		const reader = new FileReader();

		reader.onload = function(e) {
			const fileContent = e.target.result;
			data_peta = fileContent
			show_peta()
		};
		reader.readAsText(data_file);

	}

	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
	const map = new mapboxgl.Map(
	{
		container: 'maps',
		style: 'mapbox://styles/mapbox/{{env("MAPBOX_STYLE")}}',
		center: [112.03, -7.824],
		zoom: 11.5,
	});
	// console.log(map);

	show_peta()

	function show_peta(){
		if (map.getSource('data_source')) {
			// console.log('ada')
			map.removeLayer('outline')
			map.removeLayer('maine')
			map.removeSource('data_source');
			// if(map.removeSource('data_source')){
			// 	console.log('hapus data source')
			// }
			// else{
			// 	console.log('tidak hapus data source')
			// }
			data_peta = data_peta.replaceAll(' ','');
			data_peta = data_peta.replaceAll('\n','');
			data_peta = JSON.parse("{"+data_peta+"}")
			// console.log(data_peta)

			map.addSource('data_source',{
				'type':'geojson',
				'data':data_peta,
			});

			// var dataLayer = map.getSource('data_source');
			// console.log(dataLayer);
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

		}
		else{
			// console.log('tidak');
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
				// console.log(map.getSource('data_source'))
			})
		}
	}

</script>