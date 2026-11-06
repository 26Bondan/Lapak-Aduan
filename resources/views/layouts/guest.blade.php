<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal Layanan Dinas PU Banyumas') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-100">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900">
            
            {{-- BRAND / LOGO DINAS PU --}}
            <div class="mb-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo Dinas PU Banyumas"
                        class="h-16 w-auto object-contain"
                        >
                    <div>
                        <div class="text-xl font-extrabold text-white tracking-wide">
                            Portal Layanan Dinas PU
                        </div>
                        <div class="text-xs font-semibold text-yellow-300">
                            Kabupaten Banyumas
                        </div>
                    </div>
                </a>
            </div>

            {{-- CONTAINER FORM --}}
            <div class="w-full sm:max-w-md bg-white p-8 rounded-2xl shadow-2xl border border-slate-200">
                {{ $slot }}
            </div>
            
            {{-- FOOTER KECIL --}}
            <div class="mt-6 text-center text-xs text-blue-200">
                &copy; {{ date('Y') }} Dinas Pekerjaan Umum Kabupaten Banyumas
            </div>
        </div>
    </body>
</html>