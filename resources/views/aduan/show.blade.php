<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket Aduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 p-4 sm:p-8">

    @php
        // Normalisasi variabel (bisa menerima $aduan atau $laporan)
        $data = $aduan ?? $laporan ?? null;
        $subVal = $data->sub_kategori ?? '';
        $selectedSub = old('sub_kategori', !empty($subVal) ? $subVal : 'Jalan Rusak / Berlubang');
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">

        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Ubah Sub Kategori -->
        <form action="{{ route('admin.aduan.updateStatus', $data->id ?? 1) }}" method="POST" class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-slate-200">
            @csrf
            @method('PATCH')

            <label for="select-sub-kategori" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                SUB KATEGORI
            </label>
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full">
                    <select id="select-sub-kategori" name="sub_kategori" onchange="updateSubKategoriBadge(this.value)" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 block p-3 pr-10 appearance-none cursor-pointer">
                        <option value="Jalan Rusak / Berlubang" {{ $selectedSub == 'Jalan Rusak / Berlubang' ? 'selected' : '' }}>Jalan Rusak / Berlubang</option>
                        <option value="Drainase & Saluran Air" {{ $selectedSub == 'Drainase & Saluran Air' ? 'selected' : '' }}>Drainase & Saluran Air</option>
                        <option value="Penerangan Jalan Umum" {{ $selectedSub == 'Penerangan Jalan Umum' ? 'selected' : '' }}>Penerangan Jalan Umum</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-3 rounded-lg flex items-center justify-center gap-2 transition cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Terapkan</span>
                </button>
            </div>
        </form>

        <!-- Detail Tiket -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 sm:p-7 space-y-6">

            <!-- HEADER TIKET -->
            <div class="border-b border-slate-100 pb-5 space-y-3">
                
                <!-- Baris 1: Nomor Tiket + Badge Kategori Utama & Sub-Kategori Sejajar -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <span class="text-xs sm:text-sm font-bold uppercase text-slate-400 tracking-wider">
                        NOMOR TIKET:
                    </span>
                    
                    <span class="text-lg sm:text-xl font-extrabold text-blue-700 tracking-tight">
                        {{ $data->ticket_number ?? $data->ticket ?? $data->nomor_tiket ?? 'LAP-20260924-VM9RY' }}
                    </span>

                    <!-- BADGE KATEGORI UTAMA & SUB KATEGORI (DIGABUNGKAN SEJAJAR) -->
                    <span class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-medium px-3 py-1.5 rounded-full border border-slate-200">
                        <i class="fa-solid fa-folder text-amber-500"></i>
                        <span>{{ $data->kategori ?? 'Bidang Sumber Daya Air, Air Limbah dan Air Minum' }}</span>
                        
                        <span class="text-slate-400 font-bold">/</span>
                        
                        <span class="font-bold text-blue-600" id="text-sub-kategori">{{ $selectedSub }}</span>
                    </span>
                </div>

                <!-- Baris 2: Informasi Pengadu -->
                <div class="text-sm text-slate-600 pt-1 flex flex-wrap items-center gap-2">
                    <span class="font-bold text-slate-700">Pengadu:</span>
                    <span>{{ $data->nama_pengadu ?? $data->nama ?? $data->user->name ?? 'falah terfalah' }}</span>
                    <span class="text-slate-300">|</span>
                    <span class="font-bold uppercase tracking-wide text-blue-900">{{ $data->opd ?? $data->instansi ?? 'DINAS PEKERJAAN UMUM' }}</span>
                </div>

            </div>

            <!-- Judul Aduan -->
            <div>
                <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1">
                    JUDUL ADUAN:
                </h3>
                <p class="text-lg font-bold text-slate-800 capitalize">
                    {{ $data->judul_aduan ?? $data->judul ?? 'jalan berlubang' }}
                </p>
            </div>

            <!-- Deskripsi Aduan -->
            <div>
                <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1">
                    DESKRIPSI ADUAN:
                </h3>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-slate-700 text-sm font-medium">
                    {{ $data->isi_aduan ?? $data->deskripsi ?? $data->isi ?? 'motor racing' }}
                </div>
            </div>

            <!-- Form Balasan Admin -->
            <form action="{{ route('admin.aduan.updateStatus', $data->id ?? 1) }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-2 text-indigo-700 font-bold text-xs uppercase tracking-wider">
                    <i class="fa-regular fa-comments text-base"></i>
                    <span>BALASAN ADMIN:</span>
                </div>
                <textarea name="catatan" rows="4" placeholder="Tulis balasan..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>{{ old('catatan', $data->balasan ?? $data->tanggapan ?? '') }}</textarea>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition cursor-pointer">
                        Kirim Balasan
                    </button>
                </div>
            </form>

        </div>

    </div>

    <script>
        function updateSubKategoriBadge(value) {
            const badgeElem = document.getElementById('text-sub-kategori');
            if (badgeElem) {
                badgeElem.textContent = value;
            }
        }
    </script>
</body>
</html>