<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        window.codetube = {
            url: '{{ config('app.url') }}',
            user: {
                id: {{ Auth::check() ? Auth::id() : 'null' }},
                authenticated: {{ Auth::check() ? 'true' : 'false' }},
            }
        };
    </script>
</head>
<body>
    @include('layouts.partials._navigation')

    @yield('content')

    <!-- Scripts -->
    <script src="{{ url('/js/app.js') }}"></script>
</body>
</html>
