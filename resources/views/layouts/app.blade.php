<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.6.0/video-js.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/5.1.5/videojs.ads.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script>
    window.codetube = {
        url: '{{ config('app.url') }}',
        user: {
            id: {{ Auth::check() ? Auth::id() : 'null' }},
            authenticated: {{ Auth::check() ? 'true' : 'false' }},
        }
    }
    </script>
</head>
<body>
    <div id="app">
        @include('layouts.partials._navigation')
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.6.0/video.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/5.1.5/videojs.ads.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
