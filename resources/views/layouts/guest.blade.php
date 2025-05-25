<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Biletiniz') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <!-- SAYFA ORTALAYICI CONTAINER -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </div>

</body>
</html>
