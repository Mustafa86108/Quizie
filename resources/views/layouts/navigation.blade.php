<nav x-data="{ open: false }" class="bg-purple-900/70 backdrop-blur-md shadow-md fixed top-0 left-0 w-full z-50 border-b border-pink-500/30 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/Tech.png') }}" alt="TechKicks Logo" class="h-10 w-auto drop-shadow-md">
                </a>
            </div>

            <!-- Desktop Navigatie -->
            <div class="hidden sm:flex space-x-8 items-center">
                <a href="{{ route('dashboard') }}"
                   class="text-white font-medium hover:text-yellow-300 transition duration-300">
                    Dashboard
                </a>
                <a href="{{ route('books.index') }}"
                   class="text-white font-medium hover:text-yellow-300 transition duration-300">
                    Boeken
                </a>
                <a href="{{ route('quizzes.index') }}"
                   class="text-white font-medium hover:text-yellow-300 transition duration-300">
                    Quizzen
                </a>
            </div>

            <!-- Gebruikersmenu -->
            <div class="relative hidden sm:block">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center border border-transparent rounded-full focus:outline-none transition">
                            @auth
                                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                     class="h-10 w-10 rounded-full border-2 border-white shadow-lg" alt="Gebruiker">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}"
                                     class="h-10 w-10 rounded-full border shadow" alt="Gast">
                            @endauth
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-sm text-gray-800">
                            <strong>{{ Auth::user()->name ?? 'Gast' }}</strong>
                        </div>

                        @auth
                            <x-dropdown-link :href="route('profile.edit')">👤 Profiel</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 Uitloggen
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">Inloggen</x-dropdown-link>
                            <x-dropdown-link :href="route('register')">Registreren</x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobiel menu toggle -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-white text-3xl focus:outline-none hover:text-yellow-300 transition">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobiel menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
         class="sm:hidden px-4 pb-4 pt-2 space-y-2 text-white text-sm transition duration-300">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">Dashboard</a>
        <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">Boeken</a>
        <a href="{{ route('quizzes.index') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">Quizzen</a>

        @auth
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">👤 Profiel</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 hover:bg-purple-800/40">🚪 Uitloggen</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">Inloggen</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded hover:bg-purple-800/40">Registreren</a>
        @endauth
    </div>
</nav>
