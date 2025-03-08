@extends('layouts.main')
@section('title', 'Books 4 Sale')
@section('buttons')
<a class="active" href="{{ url('/') }}">Home</a>
<a href="{{ url('/addbook') }}">Add Book</a>
<a href="{{ url('/bookdetail') }}">Book Detail</a>
<a href="{{ url('/error') }}">Demo Error</a>
@stop

@section('content')
<div id="books4sale" class="menu">
    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
    <h2>Current Listings</h2>
    @foreach($books as $book)
    <section id="bid_{{ $book->book_id }}">
        <div class="content">

            <article class="item">
                <!-- <form method="GET" action="{{ url('/bookdetail') }}"> -->
                <p class="titleindex" id="bid_{{ $book->book_id }}"><a href='bookdetail?book_id={{ $book->book_id }}'>{{ $book->title }}</a></p>
                <!-- </form> -->
                <p class=" priceindex" id="bid_{{ $book->book_id }}">${{ $book->price }}</p>
            </article>

        </div>
    </section>
    @endforeach
</div>
</main>
</div>
@stop