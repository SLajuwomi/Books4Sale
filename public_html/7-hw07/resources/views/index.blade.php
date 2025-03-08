@extends('layouts.main')
@section('title', 'Books 4 Sale')
@section('buttons')
<a class="active" href="{{ url('/') }}">Home</a>
<a href="{{ url('/addbook') }}">Add Book</a>
<a href="{{ url('/bookdetail') }}">Book Detail</a>
<a href="{{ url('/error') }}">Demo Error</a>
@stop

@section('content')
<hr>
            <div id="books4sale" class="menu">
                <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                <h2>Current Listings</h2>
                <section id="bid_22">
                    <div class="content">

                        <article class="item">
                            <p class="titleindex" id="bid_22">Eye of the Gouger</p>
                            <p class="priceindex" id="bid_22">$4.99</p>
                        </article>

                    </div>
                </section>
            </div>
        </main>
    </div>
@stop
