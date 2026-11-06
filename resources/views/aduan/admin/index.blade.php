<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aduan - Admin Dinas PU Banyumas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">

    <header class="sticky top-0 z-50 bg-blue-950 text-white shadow-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Dinas PU Banyumas" class="h-10 w-auto">
                <div>
                    <h1 class="text-base font-bold leading-tight">Kelola Lapak Aduan</h1>
                    <p class="text-xs text-blue-200">Panel Administrator Dinas PU</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="rounded-lg bg-yellow-400 px-4 py-2 text-xs font-bold text-blue-950 transition hover:bg-yellow-300">
                ← Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-8">
        <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <form action="{{ request()->url() }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                
                <div>
                    <label for="tahun" class="mb-1 block text-xs font-bold uppercase text-slate-600">Tahun Aduan</label>
                    <select name="tahun" id="tahun" class="w-full cursor-pointer rounded-lg border-slate-300 px-4 py-2 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
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

                <div>
                    <label for="status" class="mb-1 block text-xs font-bold uppercase text-slate-600">Status</label>
                    <select name="status" id="status" class="w-full cursor-pointer rounded-lg border-slate-300 px-4 py-2 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ strtolower(request('status')) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ in_array(strtolower(request('status')), ['proses', 'diproses']) ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ strtolower(request('status')) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div>
                    <label for="q" class="mb-1 block text-xs font-bold uppercase text-slate-600">Cari Kata Kunci</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Tiket, judul, pelapor..." class="w-full rounded-lg border-slate-300 px-4 py-2 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full rounded-lg bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-800 shadow-sm">
                        🔍 Filter
                    </button>
                    <a href="{{ request()->url() }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-blue-950 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">No. Tiket & Kategori</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Judul Aduan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($aduan as $index => $item)
                            @php
                                $tglAd = '-';
                                $rawTgl = $item->tanggal_aduan ?? $item->created_at ?? $item->tanggal ?? null;
                                if ($rawTgl) {
                                    try {
                                        $tglAd = \Carbon\Carbon::parse($rawTgl)->format('d M Y, H:i');
                                    } catch(\Exception $e) {
                                        $tglAd = '-';
                                    }
                                }
                            @endphp
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-500">
                                    {{ method_exists($aduan, 'firstItem') ? $aduan->firstItem() + $index : $index + 1 }}
                                </td>
                                <td class="px-6 py-4 space-y-1.5">
                                    <div class="font-mono text-xs font-bold text-blue-700">
                                        {{ $item->ticket_number ?? $item->ticket ?? $item->nomor_tiket ?? 'N/A' }}
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 text-xs font-medium px-2.5 py-1 rounded-full border border-slate-200">
                                        <span>📁 {{ $item->kategori ?? 'Bidang Sumber Daya Air, Air Limbah dan Air Minum' }}</span>
                                        @if(!empty($item->sub_kategori))
                                            <span class="text-slate-400 font-bold">/</span>
                                            <span class="font-bold text-blue-600">{{ $item->sub_kategori }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $item->nama_pengadu ?? $item->nama_lengkap ?? $item->nama ?? $item->user->name ?? 'Masyarakat' }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="font-semibold text-blue-950">{{ $item->judul_aduan ?? $item->judul ?? '-' }}</div>
                                    <div class="truncate text-xs text-slate-500">{{ $item->isi_aduan ?? $item->deskripsi ?? $item->isi ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs whitespace-nowrap text-slate-500">
                                    {{ $tglAd }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch(strtolower($item->status ?? 'pending'))
                                        @case('pending')
                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">Pending</span>
                                            @break
                                        @case('proses')
                                        @case('diproses')
                                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">Diproses</span>
                                            @break
                                        @case('selesai')
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Selesai</span>
                                            @break
                                        @case('ditolak')
                                            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-800">Ditolak</span>
                                            @break
                                        @default
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-800">{{ $item->status }}</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.aduan.show', $item->id) }}" class="rounded-lg bg-blue-700 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-blue-800">
                                        ⚙️ Tanggapi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                    <p class="text-3xl">📭</p>
                                    <p class="mt-2 font-medium">Belum ada aduan yang sesuai dengan filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($aduan, 'hasPages') && $aduan->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $aduan->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>