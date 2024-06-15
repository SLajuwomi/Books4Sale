@extends('layouts.main')
@section('title', 'Error')
@section('buttons')
<a class="button" href="{{ url('/') }}">Home</a>
@stop

@section('content')
            <div class="menu">
                <h2>Something went wrong</h2>
                {{ $error_msg }}
                <img src="https://i.scdn.co/image/ab67616d00001e02da1de4c2ad1e444bc4801ff1" alt="error icon" />
                
            </div>
@stop