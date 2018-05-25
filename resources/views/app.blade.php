<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
@yield('scripts', '')

<!-- Global Spark Object -->
    <script>
        // TODO: move to a helper method, similar to Spark above, as this grows
        window.config = {
            pusher: {
                key: <?= json_encode(config('broadcasting.connections.pusher.key')) ?>,
                options: <?= json_encode(config('broadcasting.connections.pusher.options')) ?>
            }
        };
    </script>
</head>
<body>

<p>Hey</p>

<div id="app"></div>

<!-- JavaScript -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
