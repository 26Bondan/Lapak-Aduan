<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permohonan Informasi - Portal Layanan Dinas PU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js untuk mengontrol modal tanpa jQuery/Bootstrap JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-700">

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

    <main class="mx-auto max-w-7xl px-4 py-8">
        
        <!-- Pembungkus Tabel Putih -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#f8fafc] text-[#1e293b] font-bold border-b border-slate-100">
                            <th class="py-4 px-6 w-12 text-center">#</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a]">Nama Pemohon</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a]">Informasi yang Dimohon</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a]">Tujuan</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a] text-center">Status</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a] text-center">Tanggal</th>
                            <th class="py-4 px-6 font-bold text-[#1e3a8a] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($permohonans as $item)
                            <tr class="hover:bg-slate-50/50 transition" x-data="{ openDetail: false }">
                                <td class="py-4 px-6 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6 font-bold text-slate-800 uppercase tracking-wide">{{ $item->nama_lengkap }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $item->informasi_dimohon }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $item->tujuan_penggunaan }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if($item->status == 'Disetujui')
                                        <span class="inline-block px-4 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">
                                            Disetujui
                                        </span>
                                    @elseif($item->status == 'Ditolak')
                                        <span class="inline-block px-4 py-1 text-xs font-bold bg-rose-100 text-rose-800 rounded-full">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-block px-4 py-1 text-xs font-bold bg-[#fef9c3] text-[#854d0e] rounded-full">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center text-slate-500 font-medium">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <!-- Tombol Detail -->
                                    <button @click="openDetail = true" class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                                        👁 Detail
                                    </button>

                                    <!-- Modal Detail (Alpine.js) -->
                                    <div x-show="openDetail" 
                                         x-cloak
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95">
                                        
                                        <div @click.away="openDetail = false" class="bg-white rounded-2xl shadow-xl max-w-2xl w-full text-left overflow-hidden">
                                            <!-- Header Modal -->
                                            <div class="bg-[#0b1e47] px-6 py-4 text-white flex justify-between items-center">
                                                <h3 class="font-bold text-base">Detail Permohonan Informasi</h3>
                                                <button @click="openDetail = false" class="text-slate-300 hover:text-white text-lg font-bold">&times;</button>
                                            </div>

                                            <!-- Body Modal -->
                                            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto text-sm text-slate-700">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-slate-100 pb-4">
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Nama Lengkap</span>
                                                        <p class="font-bold text-slate-900 mt-0.5">{{ $item->nama_lengkap }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Jenis Pemohon</span>
                                                        <p class="font-bold text-slate-900 mt-0.5">{{ $item->jenis_pemohon }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Email</span>
                                                        <p class="font-medium text-slate-800 mt-0.5">{{ $item->email }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Nomor WhatsApp</span>
                                                        <p class="font-medium text-slate-800 mt-0.5">{{ $item->nomor_whatsapp }}</p>
                                                    </div>
                                                </div>

                                                <div class="border-b border-slate-100 pb-4">
                                                    <span class="text-xs text-slate-400 font-semibold uppercase">Alamat</span>
                                                    <p class="font-medium text-slate-800 mt-0.5">{{ $item->alamat }}</p>
                                                </div>

                                                <div class="border-b border-slate-100 pb-4">
                                                    <span class="text-xs text-slate-400 font-semibold uppercase">Informasi yang Dimohon</span>
                                                    <p class="font-medium text-slate-800 mt-0.5 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $item->informasi_dimohon }}</p>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-slate-100 pb-4">
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Format Informasi</span>
                                                        <p class="font-medium text-slate-800 mt-0.5">{{ $item->format_informasi }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-slate-400 font-semibold uppercase">Tujuan Penggunaan</span>
                                                        <p class="font-medium text-slate-800 mt-0.5">{{ $item->tujuan_penggunaan }}</p>
                                                    </div>
                                                </div>

                                                <div>
                                                    <span class="text-xs text-slate-400 font-semibold uppercase">Dokumen Pendukung</span>
                                                    <div class="mt-1">
                                                        @if($item->dokumen_pendukung)
                                                            <a href="{{ asset('storage/' . $item->dokumen_pendukung) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-lg text-xs transition border border-slate-200">
                                                                📄 Lihat / Unduh Berkas
                                                            </a>
                                                        @else
                                                            <p class="text-xs text-slate-400 italic">Tidak ada lampiran dokumen</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Footer Modal (Fitur ACC / Tolak Khusus Admin) -->
                                            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                                                <button @click="openDetail = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg text-xs transition">
                                                    Tutup
                                                </button>

                                                @auth
                                                    @if(auth()->user()->role === 'admin')
                                                        <div class="flex items-center gap-2">
                                                            <!-- Form Tolak -->
                                                            <form action="{{ route('admin.permohonan.updateStatus', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="Ditolak">
                                                                <button type="submit" onclick="return confirm('Yakin ingin menolak permohonan ini?')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-xs transition">
                                                                    ❌ Tolak
                                                                </button>
                                                            </form>

                                                            <!-- Form ACC / Setujui -->
                                                            <form action="{{ route('admin.permohonan.updateStatus', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="Disetujui">
                                                                <button type="submit" onclick="return confirm('Setujui permohonan informasi ini?')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-xs transition">
                                                                    ✅ ACC / Setujui
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data permohonan informasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($permohonans, 'links'))
            <div class="mt-4">
                {{ $permohonans->links() }}
            </div>
        @endif

    </main>

</body>
</html>