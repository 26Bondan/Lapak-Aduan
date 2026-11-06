<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portal Layanan Dinas PU Banyumas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- ================= HEADER ================= --}}
    <header class="sticky top-0 z-50 bg-blue-950 text-white shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex min-h-[68px] items-center justify-between gap-3">

                {{-- LOGO / IDENTITAS --}}
                <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-2.5 sm:gap-3">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo Dinas PU Banyumas"
                        class="h-10 w-10 shrink-0 object-contain sm:h-14 sm:w-auto"
>
                    <div class="min-w-0">
                        <div class="truncate text-sm font-bold leading-tight sm:text-lg">
                            Portal Layanan Dinas PU
                        </div>
                        <div class="text-xs text-blue-200 sm:text-sm">
                            Kabupaten Banyumas
                        </div>
                    </div>
                </a>

                {{-- NAVIGASI DESKTOP --}}
                <nav class="hidden items-center gap-5 text-sm font-medium lg:flex">
                    <a href="#beranda" id="nav-beranda"
                       class="nav-link border-b-2 border-yellow-400 py-6 text-yellow-300 font-semibold transition-all duration-200">
                        Beranda
                    </a>

                    <a href="#profil" id="nav-profil"
                       class="nav-link border-b-2 border-transparent py-6 text-white hover:text-yellow-300 transition-all duration-200">
                        Profil
                    </a>

                    <a href="#kontak" id="nav-kontak"
                       class="nav-link border-b-2 border-transparent py-6 text-white hover:text-yellow-300 transition-all duration-200">
                        Kontak
                    </a>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg bg-red-600 px-4 py-2 font-bold text-white hover:bg-red-700 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <div class="relative group">
                            <button type="button"
                                    class="flex items-center gap-1.5 rounded-lg border-2 border-yellow-400 px-4 py-2 font-bold text-yellow-400 hover:bg-yellow-400 hover:text-blue-950 transition">
                                <span>Registrasi</span>
                                <svg class="h-4 w-4 transition-transform group-hover:rotate-180"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div class="absolute right-0 z-50 mt-2 invisible w-52 rounded-xl border border-slate-100 bg-white p-2 text-slate-800 opacity-0 shadow-xl transition-all duration-200 group-hover:visible group-hover:opacity-100">
                                <a href="{{ route('register', ['role' => 'user']) }}"
                                   class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm font-semibold hover:bg-blue-50 hover:text-blue-900 transition">
                                    <span>👤</span> Registrasi
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('login') }}"
                           class="rounded-lg bg-yellow-400 px-5 py-2 font-bold text-blue-950 hover:bg-yellow-300 transition">
                            Login
                        </a>
                    @endauth
                </nav>

                {{-- MENU MOBILE --}}
                <details class="relative lg:hidden">
                    <summary class="flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-lg border border-blue-700 bg-blue-900 text-white hover:bg-blue-800">
                        <span class="sr-only">Buka menu</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </summary>

                    <div class="absolute right-0 mt-3 w-[calc(100vw-2rem)] max-w-sm rounded-2xl bg-white p-3 text-slate-800 shadow-2xl ring-1 ring-slate-200">
                        <div class="space-y-1">
                            <a href="#beranda"
                               class="block rounded-lg px-4 py-3 font-semibold hover:bg-blue-50">
                                🏠 Beranda
                            </a>

                            <a href="#profil"
                               class="block rounded-lg px-4 py-3 font-semibold hover:bg-blue-50">
                                ℹ️ Profil
                            </a>

                            <a href="#kontak"
                               class="block rounded-lg px-4 py-3 font-semibold hover:bg-blue-50">
                                📞 Kontak
                            </a>
                        </div>

                        <div class="my-3 border-t border-slate-200"></div>

                        @auth
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="block w-full rounded-lg bg-red-600 px-4 py-3 text-center font-bold text-white hover:bg-red-700">
                                    🚪 Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                               class="mb-2 block rounded-lg bg-yellow-400 px-4 py-3 text-center font-bold text-blue-950 hover:bg-yellow-300">
                                🔐 Login
                            </a>

                            <a href="{{ route('register', ['role' => 'user']) }}"
                               class="mb-2 block rounded-lg border border-blue-200 px-4 py-3 text-center font-semibold text-blue-900 hover:bg-blue-50">
                                👤 Registrasi
                            </a>
                        @endauth
                    </div>
                </details>

            </div>
        </div>
    </header>

    {{-- ================= HERO / BERANDA ================= --}}
    <section id="beranda" class="relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('images/bg.jpg') }}');">
        <div class="absolute inset-0 bg-blue-950/65"></div>
        
        <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-6 py-20 lg:grid-cols-2 lg:py-24">
            <div>
                <div class="mb-5 inline-flex rounded-full bg-yellow-400 px-4 py-2 text-sm font-bold text-blue-950">
                    PORTAL LAYANAN PUBLIK
                </div>

                <h1 class="text-4xl font-extrabold leading-tight text-white md:text-6xl">
                    Layanan Terpadu
                    <br>
                    <span class="text-yellow-300">Dinas PU Banyumas</span>
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-8 text-blue-100">
                    Akses layanan Dinas Pekerjaan Umum Kabupaten Banyumas dengan lebih mudah, cepat, transparan, dan terintegrasi.
                </p>
            </div>
        </div>
    </section>

    {{-- ================= LAYANAN KAMI ================= --}}
    <section id="layanan" class="relative bg-gradient-to-b from-slate-50 to-white px-6 py-20">
        <div class="mx-auto max-w-7xl">
            {{-- Header Layanan --}}
            <div class="mb-14 text-center">
                <span class="inline-block rounded-full bg-blue-100 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-blue-900">
                    Layanan Digital Terpadu
                </span>
                <h2 class="mt-3 text-3xl font-extrabold text-slate-900 md:text-4xl">
                    Pilihan Layanan Publik
                </h2>
                <div class="mx-auto mt-3 h-1 w-20 rounded-full bg-yellow-400"></div>
                <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                    Kemudahan akses informasi dan pengaduan untuk masyarakat Kabupaten Banyumas secara transparan dan terintegrasi.
                </p>
            </div>

            {{-- Grid Kartu Layanan --}}
            <div class="grid gap-8 md:grid-cols-3">
                
                {{-- KARTU 1: LAPAK ADUAN --}}
                <div class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-blue-500 hover:shadow-2xl hover:shadow-blue-900/10">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-50 transition-transform duration-500 group-hover:scale-150"></div>
                    
                    <div class="relative">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-3xl text-white shadow-lg shadow-blue-600/30">
                            📢
                        </div>
                        <h3 class="mt-6 text-2xl font-bold text-slate-900">Lapak Aduan</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            Sampaikan pengaduan, saran, atau keluhan infrastruktur jalan, jembatan, dan sarana umum wilayah Banyumas.
                        </p>
                    </div>

                    <div class="relative mt-8 flex flex-col gap-3">
                        @auth
                            @if(auth()->user()->role === 'admin')
                            @else
                                <a href="{{ route('aduan.create') }}" class="flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 font-bold text-white shadow-md transition hover:bg-blue-800">
                                    <span>📢 Buat Aduan</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('aduan.create') }}" class="flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 font-bold text-white shadow-md transition hover:bg-blue-800">
                                <span>📢 Buat Aduan</span>
                            </a>
                        @endauth

                        <a href="{{ route('aduan.index') }}" class="flex items-center justify-center gap-2 rounded-xl border-2 border-slate-200 bg-slate-50 px-5 py-3 font-bold text-slate-700 transition hover:border-yellow-400 hover:bg-yellow-400 hover:text-blue-950">
                            <span>📋 Daftar Aduan</span>
                        </a>
                    </div>
                </div>

                {{-- KARTU 2: PERMOHONAN INFORMASI --}}
                <div class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-amber-500 hover:shadow-2xl hover:shadow-amber-900/10">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-amber-50 transition-transform duration-500 group-hover:scale-150"></div>

                    <div class="relative">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500 text-3xl text-white shadow-lg shadow-amber-500/30">
                            ℹ️
                        </div>
                        <h3 class="mt-6 text-2xl font-bold text-slate-900">Permohonan Informasi</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            Pengajuan permohonan informasi publik resmi terkait data teknis, dokumen, serta rencana kegiatan Dinas PU.
                        </p>
                    </div>

                    <div class="relative mt-8 flex flex-col gap-3">
                        @auth
                            @if(auth()->user()->role !== 'admin')
                                <a href="{{ route('permohonan.create') }}" class="flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 font-bold text-white shadow-md transition hover:bg-blue-800">
                                    <span>ℹ️ Ajukan Permohonan</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('permohonan.create') }}" class="flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 font-bold text-white shadow-md transition hover:bg-blue-800">
                                <span>ℹ️ Ajukan Permohonan</span>
                            </a>
                        @endauth

                        <a href="{{ route('permohonan.index') }}" class="flex items-center justify-center gap-2 rounded-xl border-2 border-slate-200 bg-slate-50 px-5 py-3 font-bold text-slate-700 transition hover:border-yellow-400 hover:bg-yellow-400 hover:text-blue-950">
                            <span>📋 Daftar Permohonan</span>
                        </a>
                    </div>
                </div>

                {{-- KARTU 3: PELAYANAN PUBLIK DINAS PU --}}
                <div class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-emerald-500 hover:shadow-2xl hover:shadow-emerald-900/10">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-emerald-50 transition-transform duration-500 group-hover:scale-150"></div>

                    <div class="relative">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-600 text-3xl text-white shadow-lg shadow-emerald-600/30">
                            🏗️
                        </div>
                        <h3 class="mt-6 text-2xl font-bold text-slate-900">Pelayanan Publik</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            Layanan izin infrastruktur, sewa alat berat, dan pengujian laboratorium konstruksi Dinas PU Banyumas.
                        </p>
                    </div>

                    <div class="relative mt-8">
                        <div class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-100 py-4 font-bold text-slate-400 border border-slate-200 cursor-not-allowed">
                            <span>🔒 Segera Hadir</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= STATISTIK ================= --}}
    <section class="relative z-10 -mt-10 px-6 pb-16">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                
                {{-- Aduan Masuk --}}
                <div class="group flex items-center gap-5 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-blue-500 hover:shadow-blue-500/10">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-600 transition-transform duration-300 group-hover:scale-110">
                        📢
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900">
                            {{ \App\Models\Laporan::where('jenis_layanan', 'aduan')->count() }}
                        </p>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Aduan Masuk</p>
                    </div>
                </div>

                {{-- Permohonan Informasi --}}
                <div class="group flex items-center gap-5 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-amber-500 hover:shadow-amber-500/10">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-2xl text-amber-600 transition-transform duration-300 group-hover:scale-110">
                        ℹ️
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900">
                            {{ $totalPermohonan ?? \App\Models\Permohonan::count() }}
                        </p>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Permohonan Informasi</p>
                    </div>
                </div>

                {{-- Pelayanan --}}
                <div class="group flex items-center gap-5 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-emerald-500/10">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-600 transition-transform duration-300 group-hover:scale-110">
                        🏗️
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900">0</p>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pelayanan Publik</p>
                    </div>
                </div>

                {{-- Terselesaikan --}}
                <div class="group flex items-center gap-5 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500 hover:shadow-indigo-500/10">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-2xl text-indigo-600 transition-transform duration-300 group-hover:scale-110">
                        ✅
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900">100%</p>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Terselesaikan</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= PROFIL / TENTANG KAMI ================= --}}
    <section id="profil" class="relative bg-gradient-to-b from-white to-slate-100 px-6 py-20 overflow-hidden">
        {{-- Hiasan Elemen Dekoratif Latar Belakang --}}
        <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/2 h-96 w-96 rounded-full bg-blue-100/50 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 translate-x-1/3 h-96 w-96 rounded-full bg-yellow-100/50 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl">
            {{-- Header Profil --}}
            <div class="text-center">
                <span class="inline-block rounded-full bg-blue-100 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-blue-900">
                    Tentang Kami
                </span>
                <h2 class="mt-4 text-3xl font-extrabold text-slate-900 md:text-5xl">
                    Dinas Pekerjaan Umum <br class="hidden sm:inline">
                    <span class="text-blue-950">Kabupaten Banyumas</span>
                </h2>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-yellow-400"></div>
                
                <p class="mx-auto mt-6 max-w-3xl text-base leading-relaxed text-slate-600 md:text-lg">
                    Platform web terpadu resmi yang mengintegrasikan pengaduan masyarakat, permohonan informasi publik, dan pelayanan infrastruktur Dinas PU Banyumas dalam satu pintu secara efektif, cepat, dan transparan.
                </p>
            </div>

            {{-- Kartu Pilar Komitmen Kedinasan --}}
            <div class="mt-14 grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200/80 bg-white p-7 shadow-sm transition hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">⚡</div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Respon Cepat</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Penanganan laporan masyarakat diproses secara tanggap oleh tim teknis dinas.</p>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-7 shadow-sm transition hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-2xl">🔍</div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Transparan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Pantau seluruh perkembangan status laporan dan permohonan secara real-time.</p>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-7 shadow-sm transition hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-2xl">🤝</div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Terintegrasi</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Seluruh jenis pelayanan publik terhubung dalam satu portal resmi Kabupaten Banyumas.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FOOTER ================= --}}
    <footer id="kontak" class="bg-blue-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-12">
            <div class="grid gap-10 md:grid-cols-4">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Dinas PU Banyumas" class="h-14 w-14 rounded-lg object-contain">
                        <div>
                            <p class="font-bold">Portal Layanan Dinas PU</p>
                            <p class="text-sm text-blue-300">Kabupaten Banyumas</p>
                        </div>
                    </div>
                    <p class="mt-5 max-w-md text-sm leading-6 text-blue-300">Layanan publik Banyumas kini lebih mudah, transparan, dan mudah diakses kapan saja.</p>
                </div>

                <div>
                    <h3 class="font-bold">Layanan</h3>
                    <ul class="mt-4 space-y-3 text-sm text-blue-300">
                        <li><a href="{{ route('aduan.create') }}" class="hover:text-white transition">Lapak Aduan</a></li>
                        <li><a href="{{ route('permohonan.create') }}" class="hover:text-white transition">Permohonan Informasi</a></li>
                        <li>Pelayanan Publik</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold">Kontak</h3>
                    <ul class="mt-4 space-y-3 text-sm text-blue-300">
                        <li class="flex items-start gap-2">
                            <span>📍</span>
                            <div>
                                <div>Jl. Jenderal Gatot Subroto No. III-5</div>
                                <div>Purwokerto 53116</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>☎</span>
                            <span>(0281) 637038</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>✉</span>
                            <span>dinaspubanyumas@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-blue-800 pt-6 text-center text-sm text-blue-400">
                © {{ date('Y') }} Dinas Pekerjaan Umum Kabupaten Banyumas. Semua Hak Dilindungi.
            </div>
        </div>
    </footer>

    {{-- SCRIPT UNTUK NAVIGATION SCROLL SPY --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('section, footer');

            function updateActiveState(activeId) {
                navLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === '#' + activeId) {
                        link.classList.remove('border-transparent', 'text-white');
                        link.classList.add('border-yellow-400', 'text-yellow-300', 'font-semibold');
                    } else {
                        link.classList.remove('border-yellow-400', 'text-yellow-300', 'font-semibold');
                        link.classList.add('border-transparent', 'text-white');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const targetId = this.getAttribute('href').replace('#', '');
                    updateActiveState(targetId);
                });
            });

            window.addEventListener('scroll', () => {
                let currentSection = 'beranda';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 120;
                    if (window.scrollY >= sectionTop) {
                        currentSection = section.getAttribute('id');
                    }
                });
                if (currentSection) updateActiveState(currentSection);
            });
        });
    </script>
</body>
</html>