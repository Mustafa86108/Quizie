<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Welkom bij Leerlingen  World</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .animate-typing {
            animation: typing 3s steps(40, end), blink .75s step-end infinite;
            white-space: nowrap;
            overflow: hidden;
            border-right: 4px solid #facc15;
            width: 100%;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink {
            50% { border-color: transparent }
        }

        .card-link {
            animation: fadeInUp 0.8s ease-out both;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .card-link:hover {
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        .glow-ring {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .glow-ring:hover {
            box-shadow: 0 0 20px 4px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] min-h-screen flex flex-col items-center justify-center px-6 py-14 text-white">

    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-yellow-300 mb-4 animate-typing">
            🎓 Welkom bij Leerlingen World!
        </h1>
        <p class="text-purple-200 max-w-2xl mx-auto text-lg leading-relaxed">
            Waar leren en plezier samenkomen! Een wereld speciaal voor jou om te ontdekken, groeien en bloeien.
        </p>
    </div>

    <!-- Kaarten-sectie -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 w-full max-w-6xl px-4">
        <!-- Interactief leren -->
        <a href="{{ route('interactive.learning') }}"
           class="card-link rounded-3xl shadow-xl p-8 text-center hover:scale-105 transition-transform duration-500 glow-ring border border-purple-600">
            <img src="{{ asset('images/library.png') }}" alt="Leren"
                 class="w-24 h-24 object-cover rounded-full border-4 border-yellow-400 shadow-lg mx-auto transition-transform duration-500 hover:scale-110">
            <h2 class="mt-4 text-xl font-bold text-yellow-300">📘 Interactief Leren</h2>
            <p class="text-purple-200 mt-2 text-sm">Ontdek quizzen, games en tools om leren écht leuk te maken.</p>
        </a>

        <!-- Bibliotheek -->
        <a href="{{ route('library.explore') }}"
           class="card-link rounded-3xl shadow-xl p-8 text-center hover:scale-105 transition-transform duration-500 glow-ring border border-pink-500">
            <img src="{{ asset('images/interactive.png') }}" alt="Bibliotheek"
                 class="w-24 h-24 object-cover rounded-full border-4 border-pink-400 shadow-lg mx-auto transition-transform duration-500 hover:scale-110">
            <h2 class="mt-4 text-xl font-bold text-pink-300">📚 Bibliotheek</h2>
            <p class="text-purple-200 mt-2 text-sm">Toegang tot boeken, verhalen en kennis op één magische plek.</p>
        </a>

        <!-- Projecten -->
        <a href="{{ route('collaboration.projects') }}"
           class="card-link rounded-3xl shadow-xl p-8 text-center hover:scale-105 transition-transform duration-500 glow-ring border border-indigo-400">
            <img src="{{ asset('images/projects.png') }}" alt="Projecten"
                 class="w-24 h-24 object-cover rounded-full border-4 border-indigo-300 shadow-lg mx-auto transition-transform duration-500 hover:scale-110">
            <h2 class="mt-4 text-xl font-bold text-indigo-300">🤝 spelletjes</h2>
            <p class="text-purple-200 mt-2 text-sm">Werk samen met klasgenoten aan toffe groepsprojecten.</p>
        </a>
    </div>

    <!-- Actieknoppen -->
    <div class="flex gap-6 mt-16 flex-wrap justify-center">
        <a href="{{ route('login') }}"
           class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 px-8 py-3 rounded-full text-lg font-bold shadow-lg transition hover:scale-110 animate-bounce hover:animate-none">
            🔐 Inloggen
        </a>
        <a href="{{ route('register') }}"
           class="bg-green-400 hover:bg-green-500 text-purple-900 px-8 py-3 rounded-full text-lg font-bold shadow-lg transition hover:scale-110 animate-bounce hover:animate-none">
            📝 Registreren
        </a>
    </div>

    <!-- Footer -->
    <footer class="mt-16 text-sm text-purple-200 text-center">
        © {{ now()->year }} Leerlingen  World. Alle rechten voorbehouden.
    </footer>

</body>
</html>
