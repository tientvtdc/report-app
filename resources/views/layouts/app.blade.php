<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title') | FIT - TDC </title>
</head>
<body>

    @yield('content');
</body>
</html>
