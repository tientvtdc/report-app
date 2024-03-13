<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title') | FIT - TDC </title>
</head>
<body class="tw-bg-blue-50">

@yield('content')
@yield('script')

<input type="hidden" id="successMessage" value="{{ session('success') }}">

</body>
</html>
