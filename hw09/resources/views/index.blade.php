@extends('layouts.main')
@section('title', 'Books 4 Sale')
@section('buttons')
<a class="active" href="{{ url('/') }}">Home</a>
@if (Auth::check())
<a class="button"href="{{ url('/addbook') }}">Add Book</a>
<a class="button" href="{{ url('/logout') }}">Logout</a>
@else
<a class="button" href="{{ url('/login') }}">Login</a>
@endif
@stop

@section('content')
<div id="books4sale" class="menu">
    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
    <h2>Current Listings</h2>
    <div id="posted_books">
        @foreach($books as $book)
        <section id="bid_{{ $book->book_id }}">
            <div class="content">
                <article class="item">
                    <p class="titleindex" id="bid_{{ $book->book_id }}">{{ $book->title }}</a></p>
                    <p class=" priceindex" id="bid_{{ $book->book_id }}">${{ $book->price }}</p>
                </article>
            </div>
            <hr>
        </section>
        @csrf
        @endforeach
    </div>
</div>
</main>
</div>
@stop