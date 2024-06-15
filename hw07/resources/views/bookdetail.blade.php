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
                <article class="item">
                    <p class="title">Eye of the Gouger</p>
                    <p class="price">$4.99></p>
                    <p class="email">kindadaft@gmil.com</p>


                    <button><a href="addbook.php?book_id=22">Modify</a></button>


                    <form id="delete-button" method="POST" action="./delete-book.php?book_id=22">
                        <button><a href="delete-book.php?book_id=22">Delete</a></button>
                    </form>
                </article>
            </section>
        </div>
    </main>
</div>
@stop