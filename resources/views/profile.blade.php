<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ (auth()->user()->role === 'admin' || auth()->user()->is_admin) ? 'Profil Admin' : 'Profil Pengguna' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Flash Alert Success -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm font-semibold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- 1. KARTU EDIT PROFIL -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <h1 class="text-2xl font-extrabold text-gray-900 mb-6">
                    {{ (auth()->user()->role === 'admin' || auth()->user()->is_admin) ? 'Edit Profil Admin' : 'Edit Profil Pengguna' }}
                </h1>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Foto Profil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-6">
                            <div class="relative w-24 h-24">
                                <img 
                                    id="avatar-preview" 
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D8ABC&color=fff' }}" 
                                    alt="Foto Profil" 
                                    class="w-24 h-24 rounded-full object-cover border-2 border-slate-200 shadow-sm"
                                >
                            </div>

                            <div>
                                <input 
                                    type="file" 
                                    name="avatar" 
                                    id="avatar" 
                                    accept="image/*"
                                    onchange="previewImage(event)"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                                >
                                <p class="mt-1 text-xs text-gray-400">PNG, JPG, JPEG (Maks. 2MB)</p>
                                @error('avatar')
                                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', auth()->user()->name) }}" 
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-4"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Disabled) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                        <input 
                            type="email" 
                            value="{{ auth()->user()->email }}" 
                            disabled 
                            class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 text-sm py-2.5 px-4 cursor-not-allowed"
                        >
                    </div>

                    <!-- Info Bergabung -->
                    <div>
                        <p class="text-xs text-gray-400">
                            Bergabung Sejak: <span class="font-semibold text-gray-600">{{ auth()->user()->created_at->format('d M Y') }}</span>
                        </p>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button 
                            type="submit" 
                            class="rounded-xl bg-yellow-400 px-6 py-2.5 font-bold text-blue-950 shadow-md hover:bg-yellow-300 transition"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. TAMPILAN JIKA AKUN ADALAH ADMIN -->
            @if(strtolower(auth()->user()->role) === 'admin' || auth()->user()->is_admin)
                <div class="bg-blue-950 rounded-2xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-4 shadow-lg">
                    <div>
                        <h2 class="text-xl font-bold">Panel Administrasi Dinas PU</h2>
                        <p class="text-xs text-blue-200 mt-1">Kelola seluruh aduan dan laporan masyarakat yang masuk.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="rounded-xl bg-yellow-400 px-6 py-3 font-bold text-blue-950 hover:bg-yellow-300 transition">
                        🛡️ Buka Kelola Aduan
                    </a>
                </div>

            <!-- 3. KARTU RIWAYAT ADUAN UNTUK PENGGUNA BIASA -->
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Riwayat Aduan Saya</h2>
                            <p class="text-xs text-gray-500">Daftar laporan pengaduan yang pernah Anda kirimkan.</p>
                        </div>
                        <a href="{{ route('aduan.create') }}" class="text-xs font-bold text-blue-700 bg-blue-50 px-4 py-2 rounded-lg hover:bg-blue-100 transition">
                            + Buat Aduan Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <tr>
                                    <th class="p-4">No. Tiket</th>
                                    <th class="p-4">Judul Aduan</th>
                                    <th class="p-4">Tanggal Kirim</th>
                                    <th class="p-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php
                                    // Ambil data dari variabel controller atau dari relasi user
                                    $listAduan = $aduans ?? auth()->user()->laporans ?? auth()->user()->aduans ?? [];
                                @endphp

                                @forelse($listAduan as $aduan)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 font-mono font-bold text-blue-900">
                                            {{ $aduan->ticket_number ?? $aduan->no_tiket ?? '-' }}
                                        </td>
                                        <td class="p-4 font-medium text-slate-800">
                                            {{-- SESUAIKAN DENGAN MODEL: judul_aduan --}}
                                            {{ $aduan->judul_aduan ?? $aduan->judul ?? '-' }}
                                        </td>
                                        <td class="p-4 text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y, H:i') }}
                                        </td>
                                        <td class="p-4">
                                            @php
                                                $status = strtolower($aduan->status ?? 'pending');
                                            @endphp

                                            @if($status === 'pending')
                                                <span class="px-3 py-1 text-xs font-bold text-amber-700 bg-amber-100 rounded-full">Menunggu</span>
                                            @elseif($status === 'diproses' || $status === 'proses')
                                                <span class="px-3 py-1 text-xs font-bold text-blue-700 bg-blue-100 rounded-full">Diproses</span>
                                            @elseif($status === 'selesai')
                                                <span class="px-3 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-full">Selesai</span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-bold text-rose-700 bg-rose-100 rounded-full">{{ ucfirst($aduan->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            Anda belum pernah membuat aduan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar-preview');
                output.src = reader.result;
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>