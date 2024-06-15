@extends('layouts.main')
@section('title', 'Error')
@section('buttons')
	<a class="button" href="{{ url('/') }}">Home</a>
@stop

@section('content')
<div class="grid_6">
		<h2>Something went wrong!</h2>
		<div>
			{{ $error_msg }}
			<br>
			<a href="{{ url('/') }}">Back to Work</a>
		</div>
	</div>
@stop

