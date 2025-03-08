<div class="detail-box">
    <article class="item">
        <table>
            <tr>
                <th>Book Title</th>
                <td style="font-weight: bold; color: #ff5701;">{{ $book->title }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td style="font-weight: bold; color: #0e4692;">${{ $book->price }}</td>
            </tr>
        </table>


        @if (Auth::id() == $book->user_id)
        <form method="GET" action="{{ url('/addbook') }}">
            @csrf
            <input type="hidden" name="edit" value="{{ $book->book_id}}">
            <button>Modify</button>
        </form>

        <form id="delete-button" method="POST" action="{{ url('/delete_book') }}">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->book_id}}">
            <button>Delete</button>
        </form>
        @endif
</div>