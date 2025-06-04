<x-guest-layout>
    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-3xl shadow-lg p-8 animate-fade-in transition duration-500 ease-out transform hover:scale-[1.01]">
        <h1 class="text-center text-2xl font-semibold text-white animate-fade-in-down">Inloggen</h1>
        <p class="text-center text-gray-200 mt-2 mb-6 animate-fade-in-down delay-100">Voer je gegevens in om in te loggen.</p>

        <!-- Foutmeldingen -->
        @if ($errors->any())
            <div class="mb-4 bg-red-500/20 text-red-300 font-semibold p-4 rounded-lg text-center">
                @foreach ($errors->all() as $error)
                    @if($error == "These credentials do not match our records.")
                        <p>De combinatie van e-mailadres en wachtwoord is onjuist.</p>
                    @else
                        <p>{{ $error }}</p>
                    @endif
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4 animate-fade-in-up delay-200">
            @csrf

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Gebruikersnaam (e-mailadres)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full p-3 text-lg rounded-lg border {{ $errors->has('email') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">

                @error('email')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wachtwoord -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white">Wachtwoord</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    class="w-full p-3 text-lg rounded-lg border {{ $errors->has('password') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">

                @error('password')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Onthoud mij -->
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="remember_me" name="remember"
                    class="rounded border-white/40 bg-white/10 text-pink-500 focus:ring-pink-400">
                <label for="remember_me" class="ml-2 text-sm text-gray-200">Onthoud mij</label>
            </div>

            <!-- Submit knop -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-400 duration-200">
                    Inloggen
                </button>
            </div>

            <!-- Wachtwoord vergeten -->
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="text-sm text-pink-300 hover:underline" href="{{ route('password.request') }}">
                        Wachtwoord vergeten?
                    </a>
                @endif
            </div>
        </form>

        <!-- Registratie link -->
        <div class="text-center mt-4 animate-fade-in-up delay-300">
            <p class="text-sm text-gray-200">Nog geen account?
                <a href="{{ route('register') }}" class="text-pink-300 hover:underline">Registreer hier</a>
            </p>
        </div>
    </div>
</x-guest-layout>
