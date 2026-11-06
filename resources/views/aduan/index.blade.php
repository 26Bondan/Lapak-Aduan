<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aduan - Lapak Aduan Banyumas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800 min-h-screen">

    <!-- Header -->
    <header class="bg-blue-950 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white hover:text-blue-200">
                        Portal Layanan Dinas PU
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm hover:text-yellow-300">
                        Beranda
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Judul -->
        <div class="mb-8">
            <p class="font-bold uppercase tracking-wider text-blue-700">Lapak Aduan</p>
            <h1 class="mt-1 text-3xl font-extrabold text-blue-950">
                Daftar Aduan
            </h1>
            <p class="mt-2 text-slate-600">
                Daftar aduan yang telah disampaikan melalui Lapak Aduan Banyumas.
            </p>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between shadow-sm">
                <span>✅ {{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center justify-between shadow-sm">
                <span>⚠️ {{ session('error') }}</span>
            </div>
        @endif

        {{-- IMPORT DATA EXCEL KHUSUS ADMIN --}}
        @auth
            @if(in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'administrator', 'superadmin']))

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 mb-8">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                        <div>
                            <p class="text-sm font-bold uppercase tracking-wider text-blue-700">
                                Kelola Data
                            </p>

                            <h2 class="text-xl font-extrabold text-blue-950 mt-1">
                                📥 Import Data Aduan Excel
                            </h2>
                        </div>

                        <form
                            action="{{ route('admin.aduan.import') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3"
                        >

                            @csrf

                            <input
                                type="file"
                                name="file"
                                accept=".xls,.xlsx"
                                required
                                class="block w-full sm:w-72 text-sm text-slate-600
                                       border border-slate-300 rounded-lg
                                       bg-slate-50 cursor-pointer
                                       focus:outline-none"
                            >

                            <button
                                type="submit"
                                class="px-5 py-3 rounded-lg
                                       bg-emerald-600 text-white
                                       font-bold text-sm
                                       hover:bg-emerald-700
                                       transition shadow-sm
                                       whitespace-nowrap"
                            >
                                📤 Import Excel
                            </button>

                        </form>

                    </div>

                    @error('file')
                        <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                            ⚠️ {{ $message }}
                        </div>
                    @enderror

                </div>

            @endif
        @endauth

        <!-- Form Pencarian / Filter -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 mb-8">
            <form action="{{ route('aduan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                @auth
                    @if(in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'administrator', 'superadmin']))
                        <!-- 1. Select Tahun Aduan (Dinamis dari Controller & Fallback Manual) -->
                        <div>
                            <label for="tahun" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                                Tahun Aduan
                            </label>
                            <select 
                                name="tahun" 
                                id="tahun" 
                                class="w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm cursor-pointer focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Semua Tahun</option>
                                @if(isset($listTahun) && count($listTahun) > 0)
                                    @foreach($listTahun as $t)
                                        <option value="{{ $t }}" {{ (string)request('tahun') === (string)$t ? 'selected' : '' }}>
                                            {{ $t }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="2022" {{ request('tahun') == '2022' ? 'selected' : '' }}>2022</option>
                                    <option value="2023" {{ request('tahun') == '2023' ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                                @endif
                            </select>
                        </div>

                        <!-- 2. Select Status -->
                        <div>
                            <label for="status" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                                Status
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm cursor-pointer focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ request('status') === 'diproses' || request('status') === 'proses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <!-- 3. Select Kategori -->
                        <div class="md:col-span-2">
                            <label for="filter_kategori" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                                Kategori
                            </label>
                            <select 
                                name="kategori" 
                                id="filter_kategori" 
                                class="w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm cursor-pointer focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Bidang Sumber Daya Air, Air Limbah dan Air Minum" {{ request('kategori') == 'Bidang Sumber Daya Air, Air Limbah dan Air Minum' ? 'selected' : '' }}>
                                    Bidang Sumber Daya Air, Air Limbah dan Air Minum
                                </option>
                                <option value="Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan" {{ request('kategori') == 'Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan' ? 'selected' : '' }}>
                                    Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan
                                </option>
                                <option value="Bidang Jalan dan Drainase" {{ request('kategori') == 'Bidang Jalan dan Drainase' ? 'selected' : '' }}>
                                    Bidang Jalan dan Drainase
                                </option>
                                <option value="Bidang Penataan Ruang dan Jasa Konstruksi" {{ request('kategori') == 'Bidang Penataan Ruang dan Jasa Konstruksi' ? 'selected' : '' }}>
                                    Bidang Penataan Ruang dan Jasa Konstruksi
                                </option>
                            </select>
                        </div>

                        <!-- Tombol Submit & Reset Admin -->
                        <div class="md:col-span-4 flex items-center justify-end gap-3 pt-2">
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-700 text-white font-bold hover:bg-blue-800 transition text-sm shadow-sm">
                                🔍 Filter Data
                            </button>
                            <a href="{{ route('aduan.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition text-sm">
                                Reset
                            </a>
                        </div>

                    @else
                        <div class="md:col-span-3">
                            <label for="q" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                                Cari Aduan
                            </label>
                            <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari nomor tiket, judul, atau lokasi..." class="w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="flex items-end gap-3">
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-700 text-white font-bold hover:bg-blue-800 transition text-sm shadow-sm">
                                🔍 Cari
                            </button>
                            <a href="{{ route('aduan.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition text-sm">
                                Reset
                            </a>
                        </div>
                    @endif
                @else
                    <div class="md:col-span-3">
                        <label for="q" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                            Cari Aduan
                        </label>
                        <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari nomor tiket, judul, atau lokasi..." class="w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-700 text-white font-bold hover:bg-blue-800 transition text-sm shadow-sm">
                            🔍 Cari
                        </button>
                        <a href="{{ route('aduan.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition text-sm">
                            Reset
                        </a>
                    </div>
                @endauth

            </form>
        </div>

        @php
            $daftarAduan = $aduan ?? $laporans ?? collect();
        @endphp

        <!-- Daftar Aduan -->
        @if ($daftarAduan->count() > 0)
            <div class="space-y-6">
                @foreach ($daftarAduan as $laporan)
                    @php
                        // Membaca data sub-kategori asli dari database
                        $rawSub = trim($laporan->sub_kategori ?? $laporan->subkategori ?? '');
                        
                        // Menentukan teks fallback jika data di database NULL / Kosong
                        if (!empty($rawSub)) {
                            $subKatText = $rawSub;
                        } else {
                            $kat = $laporan->kategori ?? '';
                            if (str_contains($kat, 'Jalan')) {
                                $subKatText = 'Pembangunan & Perbaikan Jalan';
                            } elseif (str_contains($kat, 'Bangunan')) {
                                $subKatText = 'Persetujuan & Penataan Bangunan Gedung (PBG / SLF)';
                            } elseif (str_contains($kat, 'Penataan Ruang')) {
                                $subKatText = 'Penataan Ruang & Kesesuaian Pemanfaatan Ruang';
                            } else {
                                $subKatText = 'Pengelolaan & Reboisasi Sumber Daya Air (SDA)';
                            }
                        }

                        // Mengambil tanggal laporan secara aman
                        $tglFormat = '-';
                        if (!empty($laporan->tanggal_aduan)) {
                            $tglFormat = \Carbon\Carbon::parse($laporan->tanggal_aduan)->format('d M Y H:i');
                        } elseif (!empty($laporan->created_at)) {
                            $tglFormat = \Carbon\Carbon::parse($laporan->created_at)->format('d M Y H:i');
                        }
                    @endphp

                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-100">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                            <!-- Informasi Utama -->
                            <div class="flex-1 space-y-3">

                                <!-- Baris 1: Nomor Tiket & BADGE KATEGORI + SUB KATEGORI BERDAMPINGAN -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        NOMOR TIKET:
                                    </span>
                                    <span class="text-lg font-extrabold text-blue-700">
                                        {{ $laporan->ticket ?? $laporan->ticket_number ?? 'N/A' }}
                                    </span>

                                    <!-- BADGE KATEGORI UTAMA & SUB KATEGORI -->
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                                        <span>📁 {{ $laporan->kategori ?? 'Bidang Jalan dan Drainase' }}</span>
                                        <span class="text-slate-400 font-bold">/</span>
                                        <span class="text-blue-600 font-bold">🏷️ {{ $subKatText }}</span>
                                    </span>
                                </div>

                                <!-- Baris 2: Pengadu, OPD, & Media -->
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600">

                                    @if(!empty($laporan->nama_lengkap))
                                        <p>
                                            <span class="font-medium text-slate-500">Pengadu:</span>
                                            <span class="font-semibold text-slate-800">
                                                {{ $laporan->nama_lengkap }}
                                            </span>
                                        </p>
                                    @elseif(!empty($laporan->user))
                                        <p>
                                            <span class="font-medium text-slate-500">Pengadu:</span>
                                            <span class="font-semibold text-slate-800">
                                                {{ $laporan->user->name }}
                                            </span>
                                        </p>
                                    @else
                                        <p>
                                            <span class="font-medium text-slate-500">Sumber Data:</span>
                                            <span class="font-semibold text-slate-800">
                                                Masyarakat
                                            </span>
                                        </p>
                                    @endif

                                    @if(!empty($laporan->opd))
                                        <p>
                                            <span class="text-slate-300">|</span>
                                            <span class="font-bold text-blue-900">{{ $laporan->opd }}</span>
                                        </p>
                                    @endif

                                </div>

                                <!-- Judul Aduan -->
                                <div class="flex flex-col gap-0 pt-1">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 leading-none">
                                        JUDUL ADUAN:
                                    </span>
                                    <h2 class="text-base font-bold text-slate-900 leading-snug mt-1 capitalize">
                                        {{ $laporan->judul }}
                                    </h2>
                                </div>

                                <!-- Deskripsi Aduan -->
                                <div class="flex flex-col gap-0 pt-1">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 leading-none">
                                        DESKRIPSI ADUAN:
                                    </span>
                                    <p class="text-slate-900 text-base font-bold leading-snug whitespace-pre-line mt-1">
                                        {{ trim($laporan->deskripsi ?? $laporan->isi) }}
                                    </p>
                                </div>

                                <!-- Foto / Lampiran Bukti Aduan -->
                                @if (isset($laporan->files) && $laporan->files->count() > 0)
                                    <div class="pt-2">
                                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Foto / Lampiran Bukti:</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            @foreach ($laporan->files as $file)
                                                @if (in_array(strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp']))
                                                    <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="block overflow-hidden rounded-lg border border-slate-200 hover:opacity-90 transition shadow-sm">
                                                        <img src="{{ asset('storage/' . $file->path_file) }}" alt="Foto aduan" class="w-full h-32 object-cover">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="flex items-center justify-center h-32 rounded-lg border border-slate-200 bg-slate-50 text-xs font-bold text-blue-700 hover:bg-slate-100 p-2 text-center">
                                                        📄 Lihat Dokumen (PDF)
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Kotak Tampilan / Form Balasan Admin -->
                                <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                                    <p class="text-xs font-bold text-blue-950 uppercase tracking-wide">💬 Balasan Admin:</p>
                                    
                                    @auth
                                        @if(in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'administrator', 'superadmin']))
                                            <!-- Form Balas Khusus Admin -->
                                            <form action="{{ route('admin.aduan.updateStatus', $laporan->id) }}" method="POST" class="space-y-3 mt-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <input type="hidden" name="status" value="{{ $laporan->status }}">

                                                <textarea 
                                                    name="catatan" 
                                                    rows="3" 
                                                    placeholder="Tuliskan balasan/tanggapan resmi di sini..."
                                                    class="w-full rounded-lg border-slate-300 p-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                                                >{{ old('catatan', $laporan->balasan) }}</textarea>

                                                <div class="flex justify-end">
                                                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg text-xs font-bold hover:bg-blue-800 transition shadow-sm">
                                                        Simpan Balasan
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            @if($laporan->balasan)
                                                <p class="text-sm text-slate-700 leading-relaxed">{{ $laporan->balasan }}</p>
                                            @else
                                                <p class="text-xs text-slate-400 italic">Belum ada balasan resmi yang ditulis untuk aduan ini.</p>
                                            @endif
                                        @endif
                                    @else
                                        @if($laporan->balasan)
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $laporan->balasan }}</p>
                                        @else
                                            <p class="text-xs text-slate-400 italic">Belum ada balasan resmi yang ditulis untuk aduan ini.</p>
                                        @endif
                                    @endauth
                                </div>

                                <!-- Footer Info Lokasi & Tanggal -->
                                <div class="pt-2 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-400">
                                    <span>📍 Lokasi: <span class="text-slate-600">{{ $laporan->lokasi ?? 'Banyumas' }}</span></span>
                                    <span>🗓️ Tgl Aduan: <span class="text-slate-600">{{ $tglFormat }}</span></span>
                                </div>

                            </div>

                            <!-- Badges Status / Dropdown Ubah Status -->
                            <div class="self-start">
                                @auth
                                    @if(in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'administrator', 'superadmin']))
                                        <form action="{{ route('admin.aduan.updateStatus', $laporan->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="catatan" value="{{ $laporan->balasan }}">
                                            <select name="status" onchange="this.form.submit()" class="cursor-pointer rounded-full bg-amber-100 px-4 py-1.5 text-xs font-bold text-amber-900 border border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-sm">
                                                <option value="Pending" {{ strtolower($laporan->status) == 'pending' ? 'selected' : '' }}>Pending ⚙️</option>
                                                <option value="Diproses" {{ strtolower($laporan->status) == 'diproses' || strtolower($laporan->status) == 'proses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Selesai" {{ strtolower($laporan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-4 py-1.5 text-xs font-bold text-amber-800 border border-amber-200">
                                            {{ ucfirst($laporan->status ?? 'Pending') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-4 py-1.5 text-xs font-bold text-amber-800 border border-amber-200">
                                        {{ ucfirst($laporan->status ?? 'Pending') }}
                                    </span>
                                @endauth
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $daftarAduan->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                    📋
                </div>
                <h3 class="text-lg font-bold text-slate-800">Belum ada aduan yang ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1 mb-6">Laporan atau aduan yang dikirimkan akan muncul di sini.</p>

                @if(!in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'administrator', 'superadmin']))
                    <a href="{{ route('aduan.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm rounded-lg transition shadow-sm">
                        + Buat Aduan Baru
                    </a>
                @endif
            </div>
        @endif

    </main>

</body>
</html>