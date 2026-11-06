<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kelola Aduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Button Kelola Aduan -->
        <div class="inline-flex items-center bg-amber-400 text-slate-900 px-6 py-3 rounded-2xl font-bold text-xl shadow-lg">
            <i class="fa-solid fa-shield-halved text-sky-500 text-2xl mr-3"></i>
            <span>Kelola Aduan</span>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Admin Dashboard -->
        <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-700/60 text-slate-300 border-b border-slate-700">
                            <th class="p-4">No. Tiket</th>
                            <th class="p-4">Pelapor</th>
                            <th class="p-4">Judul & Lokasi</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($laporans as $item)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="p-4 font-mono text-amber-400 font-medium">{{ $item->ticket_number }}</td>
                                <td class="p-4 font-semibold text-white">{{ $item->user->name ?? 'Anonim' }}</td>
                                <td class="p-4">
                                    <div class="font-medium text-white">{{ $item->judul }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->lokasi }}</div>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('aduan.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="bg-slate-900 text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-600 focus:outline-none focus:border-amber-400">
                                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('aduan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus aduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-500/20 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs transition">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">Belum ada aduan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-700">
                {{ $laporans->links() }}
            </div>
        </div>

    </div>
</body>
</html>