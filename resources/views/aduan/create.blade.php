<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form Pengaduan - Portal Layanan Dinas PU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    {{-- HEADER --}}
    <header class="bg-blue-950 text-white shadow">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <div class="flex items-center gap-3">
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Logo"
                    class="h-12 w-12 rounded-lg object-contain"
                >

                <div>
                    <h1 class="font-bold">
                        Portal Layanan Dinas PU
                    </h1>

                    <p class="text-sm text-blue-200">
                        Kabupaten Banyumas
                    </p>
                </div>
            </div>

            <a
                href="{{ route('home') }}"
                class="text-sm hover:text-yellow-300"
            >
                ← Kembali
            </a>

        </div>
    </header>


    {{-- MAIN CONTENT --}}
    <main class="mx-auto max-w-4xl px-6 py-10">

        <!-- HEADER TITLE & DESKRIPSI -->
        <div class="mb-8">
            <p class="font-bold uppercase tracking-wider text-blue-700">
                LAYANAN PUBLIK
            </p>

            <h2 class="mt-2 text-3xl font-extrabold text-blue-950">
                Formulir Pengaduan Masyarakat
            </h2>

            <p class="mt-2 text-slate-600">
                Sampaikan laporan atau pengaduan mengenai fasilitas dan infrastruktur publik di Kabupaten Banyumas.
            </p>
        </div>


        {{-- ERROR ALERT --}}
        @if ($errors->any())

            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">

                <p class="font-bold">
                    Ada data yang perlu diperbaiki:
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM ADUAN --}}
        <form
            action="{{ route('aduan.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="rounded-2xl bg-white p-6 shadow-lg md:p-8"
        >

            @csrf


            {{-- NAMA LENGKAP --}}
            <div class="mb-6">

                <label class="mb-2 block font-semibold text-slate-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', auth()->user()->name ?? '') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                    required
                >

            </div>


            {{-- EMAIL & WHATSAPP --}}
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>
                    <label class="mb-2 block font-semibold text-slate-700">
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email ?? '') }}"
                        placeholder="contoh@gmail.com"
                        pattern="[A-Za-z0-9._%+-]+@gmail\.com"
                        title="Email harus menggunakan alamat Gmail, contoh: nama@gmail.com"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block font-semibold text-slate-700">
                        Nomor WhatsApp/Telepon <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="tel"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                        required
                    >
                </div>

            </div>


            {{-- ALAMAT --}}
            <div class="mb-6">

                <label class="mb-2 block font-semibold text-slate-700">
                    Alamat <span class="text-red-500">*</span>
                </label>

                <textarea
                    name="alamat"
                    rows="3"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                    required
                >{{ old('alamat') }}</textarea>

            </div>


            {{-- JUDUL ADUAN --}}
            <div class="mb-6">

                <label class="mb-2 block font-semibold text-slate-700">
                    Judul Aduan <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    placeholder="Contoh: Permohonan Uji Sampel Beton Konstruksi"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                    required
                >

            </div>


            {{-- KATEGORI & SUB KATEGORI (DINAMIS) --}}
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- KATEGORI --}}
                <div>
                    <label class="mb-2 block font-semibold text-slate-700">
                        Kategori <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="kategori"
                        name="kategori"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Bidang Sumber Daya Air, Air Limbah dan Air Minum" {{ old('kategori') == 'Bidang Sumber Daya Air, Air Limbah dan Air Minum' ? 'selected' : '' }}>
                            Bidang Sumber Daya Air, Air Limbah dan Air Minum
                        </option>
                        <option value="Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan" {{ old('kategori') == 'Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan' ? 'selected' : '' }}>
                            Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan
                        </option>
                        <option value="Bidang Jalan dan Drainase" {{ old('kategori') == 'Bidang Jalan dan Drainase' ? 'selected' : '' }}>
                            Bidang Jalan dan Drainase
                        </option>
                        <option value="Bidang Penataan Ruang dan Jasa Konstruksi" {{ old('kategori') == 'Bidang Penataan Ruang dan Jasa Konstruksi' ? 'selected' : '' }}>
                            Bidang Penataan Ruang dan Jasa Konstruksi
                        </option>
                    </select>
                </div>

                {{-- SUB KATEGORI / LAYANAN --}}
                <div>
                    <label class="mb-2 block font-semibold text-slate-700">
                        Sub Kategori <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="sub_kategori"
                        name="sub_kategori"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                        required
                    >
                        <option value="">-- Pilih Sub Kategori --</option>
                    </select>
                </div>
            </div>


            {{-- LOKASI KEJADIAN --}}
            <div class="mb-6">
                <label class="mb-2 block font-semibold text-slate-700">
                    Lokasi Kejadian <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="lokasi"
                    value="{{ old('lokasi') }}"
                    placeholder="Contoh: Jl. Jenderal Soedirman, Purwokerto"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                    required
                >

                <p class="mt-2 text-xs text-slate-500">
                    Isi lokasi tempat masalah atau kejadian dilaporkan.
                </p>
            </div>


            {{-- DESKRIPSI ADUAN --}}
            <div class="mb-6">

                <label class="mb-2 block font-semibold text-slate-700">
                    Deskripsi Aduan <span class="text-red-500">*</span>
                </label>

                <textarea
                    name="deskripsi"
                    rows="4"
                    placeholder="Jelaskan permasalahan secara lengkap..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-200"
                    required
                >{{ old('deskripsi') }}</textarea>

            </div>


            {{-- FILE DOKUMEN / FOTO PENDUKUNG --}}
            <div class="mb-6">

                <label class="mb-2 block font-semibold text-slate-700">
                    Upload Foto Lampiran <span class="font-normal text-slate-500">(Opsional)</span>
                </label>

                <input
                    type="file"
                    name="foto_lampiran"
                    accept=".jpg,.jpeg,.png"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Format file: JPG, PNG (Maksimal 5 MB).
                </p>

            </div>


            {{-- CHECKBOX PERSETUJUAN --}}
            <div class="mb-8 flex items-start gap-3">

                <input
                    type="checkbox"
                    name="persetujuan"
                    id="persetujuan"
                    value="1"
                    class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-200"
                    required
                >

                <label for="persetujuan" class="text-sm text-slate-700">
                    Saya menyatakan bahwa data dan laporan yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                </label>

            </div>


            {{-- TOMBOL --}}
            <div class="flex flex-col gap-3 sm:flex-row">

                <a
                    href="{{ route('home') }}"
                    class="rounded-lg border border-slate-300 px-6 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-blue-700 px-6 py-3 font-bold text-white hover:bg-blue-800"
                >
                    Kirim Aduan
                </button>

            </div>

        </form>

    </main>

    {{-- JAVASCRIPT UNTUK SUB KATEGORI DINAMIS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kategoriSelect = document.getElementById('kategori');
            const subKategoriSelect = document.getElementById('sub_kategori');

            // Data sub-kategori disesuaikan dengan 4 bidang utama
            const subKategoriData = {
                "Bidang Sumber Daya Air, Air Limbah dan Air Minum": [
                    "Pengelolaan & Reboisasi Sumber Daya Air (SDA)",
                    "Sistem Pengelolaan Air Limbah Domestik & Industri",
                    "Penyediaan & Jaringan Air Minum"
                ],
                "Bidang Bangunan Gedung, Penataan Bangunan dan Lingkungannya, Permukiman dan Persampahan": [
                    "Persetujuan & Penataan Bangunan Gedung (PBG / SLF)",
                    "Penataan Kawasan Permukiman",
                    "Pengelolaan & Pengangkutan Persampahan"
                ],
                "Bidang Jalan dan Drainase": [
                    "Pembangunan & Perbaikan Jalan",
                    "Sistem Drainase & Pengendalian Banjir"
                ],
                "Bidang Penataan Ruang dan Jasa Konstruksi": [
                    "Penataan Ruang & Kesesuaian Pemanfaatan Ruang",
                    "Pembinaan, Pengujian & Pengawasan Jasa Konstruksi"
                ]
            };

            // Menyimpan nilai lama dari Laravel jika form di-reload
            const oldSubKategori = "{{ old('sub_kategori') }}";

            function updateSubKategori() {
                const selectedKategori = kategoriSelect.value;

                // Reset opsi sub-kategori
                subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

                if (selectedKategori && subKategoriData[selectedKategori]) {
                    subKategoriData[selectedKategori].forEach(function (sub) {
                        const option = document.createElement('option');
                        option.value = sub;
                        option.textContent = sub;

                        if (sub === oldSubKategori) {
                            option.selected = true;
                        }

                        subKategoriSelect.appendChild(option);
                    });
                }
            }

            // Jalankan event listener saat opsi dipilih
            kategoriSelect.addEventListener('change', updateSubKategori);

            // Jalankan saat pertama kali halaman di-load jika sudah ada nilai sebelumnya (old value)
            if (kategoriSelect.value) {
                updateSubKategori();
            }
        });
    </script>

</body>
</html>