<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] min-h-screen flex flex-col justify-center items-center text-white relative">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/30 z-0"></div>

    <!-- Logo -->
    <a href="/" class="relative z-10 mb-6">
        <img src="{{ asset('images/Tech.png') }}" alt="TechKicks Logo" class="h-16 w-auto">
    </a>

    <!-- Page content -->
    <div class="relative z-10 w-full max-w-md">
        {{ $slot }}
    </div>

</body>
</html>
