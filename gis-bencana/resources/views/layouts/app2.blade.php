<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PEMETAAN BENCANA</title>
	<link href="{{asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	@stack('csss')
</head>
<body>
	@yield('content')
	<script src="{{asset('NiceAdmin/assets/js/main.js')}}"></script>
	@stack('jss')
</body>
</html>