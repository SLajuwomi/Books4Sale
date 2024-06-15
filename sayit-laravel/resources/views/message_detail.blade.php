<div class="detail-box">
    <table>
        <tr>
            <th>Time</th>
            <td>{{$message -> ts}}</td>
        </tr>
        <tr>
            <th>Topic</th>
            <td>{{$message -> topic}}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{$message -> message}}</td>
        </tr>
        <tr>
            <th>Author Name</th>
            <td>{{$message -> screen_name}}</td>
        </tr>
        <tr>
            <th>Author email</th>
            <td>{{$message -> email}}</td>
        </tr>
    </table>
    @if (Auth::id() == $message->user_id)
    <form method="GET" action="{{ url('/') }}">
        <input type="hidden" name="edit" value="{{ $message->message_id }}">
        <button>Change</button>
    </form>
    <form method="POST" action="{{ url('/delete_message') }}">
        @csrf
        <input type="hidden" name="msg-id" value="{{ $message->message_id }}">
        <button>Delete</button>
    </form>
    @endif
</div>