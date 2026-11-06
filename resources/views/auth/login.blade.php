<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 border-b border-slate-100 pb-4 text-center">
        <h2 class="text-2xl font-extrabold text-blue-950">Masuk Akun</h2>
        <p class="mt-1 text-xs text-slate-500">Silakan login untuk mengakses layanan Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-blue-950" />
            <x-text-input 
                id="email" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="contoh@gmail.com"
                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                title="Email harus menggunakan format domain @gmail.com (Contoh: contoh@gmail.com)"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="font-semibold text-blue-950" />
            <x-text-input 
                id="password" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Lupa Password -->
        <div class="mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-yellow-500 shadow-sm focus:ring-yellow-400" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-blue-700 hover:text-blue-900 transition" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full rounded-lg bg-yellow-400 px-5 py-3 font-bold text-blue-950 shadow-md transition hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                LOG IN
            </button>
        </div>

        <!-- Link Registrasi -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:underline">
                Daftar Sekarang
            </a>
        </div>
    </form>
</x-guest-layout>