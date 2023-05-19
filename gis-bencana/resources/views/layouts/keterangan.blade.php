@push('csss')
<style type="text/css">
	.legend {
		background-color: #fff;
		border-radius: 3px;
		bottom: 30px;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
		padding: 10px;
		position: absolute;
		right: 10px;
		z-index: 1;
	}

	.legend h4 {
		margin: 0 0 10px;
	}

	.legend div span {
		border-radius: 50%;
		display: inline-block;
		height: 10px;
		margin-right: 5px;
		width: 10px;
	}

	.legend2 {
		background-color: #fff;
		border-radius: 3px;
		bottom: 30px;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
		padding: 10px;
		position: absolute;
		left: 10px;
		z-index: 1;
	}

	.legend2 h4 {
		margin: 0 0 10px;
	}

	.legend2 div span {
		border-radius: 50%;
		display: inline-block;
		height: 10px;
		margin-left: 5px;
		width: 10px;
	}

	.marker {
		background-image: url('mapbox-icon.png');
		background-size: cover;
		width: 50px;
		height: 50px;
		border-radius: 50%;
		cursor: pointer;
	}

	.mapboxgl-popup {
		max-width: 400px;
		font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
	}

	.coordinates {
		background: rgba(0, 0, 0, 0.5);
		color: #fff;
		position: absolute;
		bottom: 60px;
		left: 40px;
		padding: 5px 10px;
		margin: 0;
		font-size: 11px;
		line-height: 18px;
		border-radius: 3px;
		display: none;
	}
</style>
@endpush

<div id="state-legend" class="legend">
	<h6>Keterangan</h6>
	<div><span style="background-color: #360602"></span>Tinggi ( 60% - 100% )</div>
	<div><span style="background-color: #fc7600"></span>Medium ( 30% - 59% )</div>
	<div><span style="background-color: #5cfc00"></span>Rendah ( 0% - 29% )</div>
</div>