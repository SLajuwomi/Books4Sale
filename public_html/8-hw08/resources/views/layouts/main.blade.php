<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('styles.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ asset('books.js') }}" defer></script>
</head>

<body>

    <div class="menu">
        <main>
            <h1>Books 4 Sale</h1>
            <div class="topnav">
                @yield('buttons')
            </div>
            <hr>
            @yield('content')
</body>

</html>