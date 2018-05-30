<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="csrf-token" content="asdf1234">

    <title>@yield('title', config('app.name'))</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

<!-- Global Spark Object -->
    <script>
        window.config = {
            pusher: {
                key: <?= json_encode(config('broadcasting.connections.pusher.key')) ?>,
                options: <?= json_encode(config('broadcasting.connections.pusher.options')) ?>
            }
        };
    </script>
</head>
<body>

<div id="progress">
    <team-progress-container :teams="{{{ json_encode($teams) }}}"></team-progress-container>
</div>

<!-- JavaScript -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
