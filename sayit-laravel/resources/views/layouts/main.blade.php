<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>
	<link href=" {{ asset('css/sayit.css') }}" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Asul' rel='stylesheet' type='text/css'>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="" crossorigin="anonymous"></script>
	<script src="{{ asset('js/sayit.js') }}" integrity="" defer></script>
</head>

<body>
	<h1>Say It!&trade;@yield('buttons')</h1>
		</h1>
	@yield('content')
</body>
</html>
