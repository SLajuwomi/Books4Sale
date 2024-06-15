@extends('layouts.main')
@section('title', 'SayIt!')
@section('buttons')
@if (Auth::check())
<a class="button" href="{{ url('/logout') }}">Logout</a>
@else
<a class="button" href="{{ url('/login') }}">Login</a>
@endif
@stop

@section('content')
<div class="grid_6">
	<h2>What's Been Said ...</h2>
	<div id="beensaid">
		@foreach($messages as $message)
		<section id="mid_{{ $message->message_id }}">
			<div class="content">
				<span class=" topic">{{ $message->topic }}</span>
				<span class="who">{{ $message->screen_name }}</span>
				{{ $message->message }}
			</div>
			<hr>
		</section>
		@endforeach
	</div>

	<button class="big-button" id="update">Update!</button>
</div>

<div class="grid_6">
	<h2>Say It Yourself ...</h2>
	<div id="sayit">
		<form method="POST" action="{{ url('/save_message') }}">
			<label>Topic:</label>
			<select name="existing-topic">
				@foreach ($topics as $topic)
				@if ($topic->topic == old('existing-topic', $prev->topic))
				<option selected="selected">{{ $topic->topic }}</option>
				@else
				<option>{{ $topic->topic }}</option>
				@endif
				@endforeach
			</select>
			or
			<input type="text" name="new-topic" value=" {{ old('new-topic') }}" />

			@if ($errors->has('existing-topic') || $errors->has('new-topic'))
			<div class="error">
				{{ $errors->first('existing-topic') }}
				{{ $errors->first('new-topic') }}
			</div>
			@endif

			<label>Message (limit 500 chars)</label><br />
			<textarea name="message">{{ old('message', $prev->message) }}</textarea>
			@if ($errors->has('message'))
			<div class="error">{{ $errors->first('message') }}</div>
			@endif
			<button class="big-button">Say It!</button>
			@csrf
			<input type="hidden" name="edit" value="{{ $edit }}">
		</form>
	</div>
</div>
@if ($errors->has('existing-topic') || $errors->has('new-topic') || $errors->has('message') || $prev->message!='')
<script>
	$('html,body').animate({
		scrollTop: document.body.scrollHeight
	}, "slow");
</script>
@endif

@stop