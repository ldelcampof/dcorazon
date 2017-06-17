<!DOCTYPE html>
<html>
<head>
	<title>DCorazon</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="https://use.fontawesome.com/7dbcd6e557.js"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
	<div id="app">
		@yield('content')
	</div>

	<script type="text/javascript">
		window.url = "{{ env('APP_URL') }}";
		window.Laravel = <?php echo json_encode([
	        'csrfToken' => csrf_token(),
	    ]); ?>
	</script>
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>