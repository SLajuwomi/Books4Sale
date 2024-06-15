@extends('layouts.main')
@section('title', 'Book Detail')
@section('buttons')
<a href="{{ url('/') }}">Home</a>
<a href="{{ url('/addbook') }}">Add Book</a>
<a class="active" href="{{ url('/bookdetail') }}">Book Detail</a>
<a href="{{ url('/error') }}">Demo Error</a>
@stop

@section('content')
<div class="menu">
    <h2>Change Book Details</h2>
    <section>
        <div id="detail-box">
            <article class="item">
                @foreach($books as $book)
                <p class="title" id="bid_{{ $id }}">{{ $book->title }}</p>
                <p class="price" id="bid_{{ $id }}">${{ $book->price }}</p>
                @endforeach


                <button><a href="addbook.php?book_id={{ $id }}">Modify</a></button>
                <button><a href="addbook.php?book_id=<?php echo $id; ?>">Modify</a></button>

                <form id="delete-button" method="POST" action="{{ url('/delete_book') }}">
                    <input type="hidden" name="book-id" value="">
                    <button>Delete</button>
                </form>
            </article>
            <div>
    </section>
    @csrf
</div>
</main>
</div>
@stop