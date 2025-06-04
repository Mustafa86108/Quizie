<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts via Bunny.net -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind + App CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fallback achtergrond om flits te voorkomen -->
    <style>
        html, body {
            background: linear-gradient(to bottom right, #2a003f, #4b0b8a, #c9184a); /* zelfde als quiz style */
            min-height: 100vh;
            margin: 0;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<!-- Direct Tailwind fallback gradient -->
<body class="font-sans antialiased bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white">

    <!-- Navigatie -->
    @include('layouts.navigation')

    <!-- Pagina-wrapper -->
    <div class="min-h-screen animate-fade-in">

        <!-- Header -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Pagina-inhoud -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @yield('scripts')

</body>
</html>
