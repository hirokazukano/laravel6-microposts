<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', config('app.name') . 'です。')">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @if (App::environment('local'))
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/index.min.css') }}">
    @endif
</head>
<body>

@include('commons.navbar')

<div class="container">
    @include('commons.messages')
    @include('commons.error_messages')

    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
@if (App::environment('local'))
    <script src="{{ asset('js/js1.js') }}"></script>
    <script src="{{ asset('js/js2.js') }}"></script>
@else
    <script src="{{ asset('js/index.min.js') }}"></script>
@endif
</body>
</html>
