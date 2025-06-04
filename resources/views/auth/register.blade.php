<x-guest-layout>
    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-3xl shadow-lg p-10 animate-fade-in text-white">
        <h1 class="text-center text-3xl font-semibold animate-fade-in-down">Registreren</h1>
        <p class="text-center text-gray-200 mt-2 mb-6 animate-fade-in-down delay-100">Maak een nieuw account aan.</p>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-6 animate-fade-in-up delay-200">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Naam -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-white">Gebruikersnaam</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full p-3 text-lg rounded-lg border {{ $errors->has('name') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">

                    @error('name')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full p-3 text-lg rounded-lg border {{ $errors->has('email') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">

                    @error('email')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="role" class="block text-sm font-medium text-white">Kies je rol:</label>
                    <select id="role" name="role" required
                        class="w-full p-3 text-lg rounded-lg border {{ $errors->has('role') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-gray-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 appearance-none">
                            <option value="">-- Selecteer --</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Leerling</option>
                            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Leraar</option>
                    </select>

                    @error('role')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wachtwoord -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white">Wachtwoord</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full p-3 text-lg rounded-lg border {{ $errors->has('password') ? 'border-red-500' : 'border-white/40' }} bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">

                    @error('password')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Herhaal wachtwoord -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-white">Bevestig Wachtwoord</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full p-3 text-lg rounded-lg border border-white/40 bg-[#2a003f] text-white placeholder-gray-300 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 px-4 rounded-lg shadow-md text-xl font-semibold transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    Registreren
                </button>
            </div>

            <!-- Link naar login -->
            <div class="text-center">
                <p class="text-sm text-gray-200">Heb je al een account?
                    <a href="{{ route('login') }}" class="text-pink-300 hover:underline">Log hier in</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
