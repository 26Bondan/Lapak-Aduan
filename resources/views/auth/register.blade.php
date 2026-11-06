<x-guest-layout>
    <div class="mb-6 border-b border-slate-100 pb-4 text-center">
        {{-- JUDUL BERUBAH SESUAI DENGAN PILIHAN ROLE DARI NAVBAR --}}
        <h2 class="text-2xl font-extrabold text-blue-950">
            Registrasi {{ request('role') === 'admin' ? 'Admin' : 'Pengguna' }}
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            {{ request('role') === 'admin' ? 'Buat akun admin untuk mengelola pengaduan' : 'Buat akun untuk mengajukan aduan dan layanan PU' }}
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- TAMBAHKAN INPUT HIDDEN ROLE DI SINI --}}
        <input type="hidden" name="role" value="{{ request('role', 'user') }}">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-blue-950" />
            <x-text-input 
                id="name" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Masukkan nama lengkap"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email (Wajib @gmail.com)')" class="font-semibold text-blue-950" />
            <x-text-input 
                id="email" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
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
                autocomplete="new-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-semibold text-blue-950" />
            <x-text-input 
                id="password_confirmation" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full rounded-lg bg-yellow-400 px-5 py-3 font-bold text-blue-950 shadow-md transition hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                DAFTAR AKUN {{ request('role') === 'admin' ? 'ADMIN' : 'PENGGUNA' }}
            </button>
        </div>

        <!-- Link Login -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:underline">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>