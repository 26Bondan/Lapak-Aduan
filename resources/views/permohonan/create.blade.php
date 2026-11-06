<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi - Portal Layanan Dinas PU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-700 font-sans pb-12">

    {{-- HEADER --}}
    <header class="bg-[#0b1e47] text-white shadow">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-10 w-10 rounded-lg object-contain">
                <div>
                    <h1 class="font-bold text-base">Portal Layanan Dinas PU</h1>
                    <p class="text-xs text-blue-200">Kabupaten Banyumas</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="text-sm hover:text-yellow-300">← Kembali</a>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="mx-auto max-w-4xl px-6 py-10">

        <!-- HEADER TITLE & DESKRIPSI -->
        <div class="mb-8">
            <p class="font-bold uppercase tracking-wider text-blue-700">
                LAYANAN PERMOHONAN
            </p>

            <h2 class="mt-2 text-3xl font-extrabold text-blue-950">
                Formulir Permohonan Informasi
            </h2>

            <p class="mt-2 text-slate-600">
                Selamat datang di layanan permohonan informasi publik Dinas Pekerjaan Umum Kabupaten Banyumas. Silakan mengisi formulir ini dengan lengkap dan benar. Permohonan akan diproses sesuai ketentuan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik dan Peraturan Komisi Informasi Nomor 1 Tahun 2021 tentang Standar Layanan Informasi Publik. 
            </p>
        </div>

        {{-- CONTAINER FORM --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">

            {{-- ERROR ALERT --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 text-sm">
                    <p class="font-bold">Ada data yang perlu diperbaiki:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                </div>

                {{-- Email & No WhatsApp --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">Email <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@gmail.com"
                            pattern="[A-Za-z0-9._%+-]+@gmail\.com"
                            title="Email harus menggunakan alamat Gmail, contoh: nama@gmail.com"
                            oninput="this.value = this.value.toLowerCase()"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                    </div>
                </div>

                {{-- Jenis Pemohon & Nama Instansi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">Jenis Pemohon <span class="text-red-500">*</span></label>
                        <select name="jenis_pemohon" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                            <option value="" disabled selected>Pilih jenis pemohon</option>
                            <option value="PERORANGAN" {{ old('jenis_pemohon') == 'PERORANGAN' ? 'selected' : '' }}>PERORANGAN</option>
                            <option value="MAHASISWA" {{ old('jenis_pemohon') == 'MAHASISWA' ? 'selected' : '' }}>MAHASISWA</option>
                            <option value="KELOMPOK MASYARAKAT" {{ old('jenis_pemohon') == 'KELOMPOK MASYARAKAT' ? 'selected' : '' }}>KELOMPOK MASYARAKAT</option>
                            <option value="LSM/ORGANISASI" {{ old('jenis_pemohon') == 'LSM/ORGANISASI' ? 'selected' : '' }}>LSM / ORGANISASI</option>
                            <option value="BADAN HUKUM" {{ old('jenis_pemohon') == 'BADAN HUKUM' ? 'selected' : '' }}>BADAN HUKUM</option>
                            <option value="INSTANSI PEMERINTAH" {{ old('jenis_pemohon') == 'INSTANSI PEMERINTAH' ? 'selected' : '' }}>INSTANSI PEMERINTAH</option>
                            <option value="MEDIA MASSA" {{ old('jenis_pemohon') == 'MEDIA MASSA' ? 'selected' : '' }}>MEDIA MASSA</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Instansi / Organisasi <span class="text-slate-500 font-normal">(Jika ada)</span></label>
                        <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" placeholder="Masukkan nama instansi/organisasi" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-y" required>{{ old('alamat') }}</textarea>
                </div>

                {{-- Informasi yang Dimohon --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Informasi yang Dimohon <span class="text-red-500">*</span></label>
                    <textarea name="informasi_dimohon" rows="4" placeholder="Jelaskan informasi yang Anda minta secara jelas dan spesifik..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-y" required>{{ old('informasi_dimohon') }}</textarea>
                </div>

                {{-- Tujuan Penggunaan Informasi --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Tujuan Penggunaan Informasi <span class="text-red-500">*</span></label>
                    <select name="tujuan_penggunaan" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                        <option value="" disabled selected>Pilih tujuan</option>
                        <option value="Penelitian" {{ old('tujuan_penggunaan') == 'Penelitian' ? 'selected' : '' }}>Penelitian / Akademis</option>
                        <option value="Kepentingan Hukum" {{ old('tujuan_penggunaan') == 'Kepentingan Hukum' ? 'selected' : '' }}>Kepentingan Hukum</option>
                        <option value="Informasi Magang" {{ old('tujuan_penggunaan') == 'Informasi Magang' ? 'selected' : '' }}>Informasi Magang</option>
                        <option value="Lainnya" {{ old('tujuan_penggunaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Upload Dokumen Pendukung --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Upload Dokumen Pendukung <span class="text-slate-500 font-normal">(Opsional)</span></label>
                    <input type="file" name="dokumen_pendukung" accept=".jpg,.jpeg,.png,.pdf" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-600 focus:outline-none">
                    <p class="text-xs text-slate-400 mt-1.5">Format file: PDF, JPG, PNG (Maksimal 10 MB).</p>
                </div>

                {{-- Checkbox Persetujuan --}}
                <div class="flex items-start gap-3 pt-2">
                    <input type="checkbox" name="persetujuan" id="persetujuan" value="1" class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500" required>
                    <label for="persetujuan" class="text-sm text-slate-600">Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.</label>
                </div>

                {{-- Action Buttons (Batal & Ajukan Permohonan) --}}
                <div class="flex items-center gap-4 pt-4">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-[#2563eb] hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition shadow-sm">
                        Ajukan Permohonan
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>
</html>