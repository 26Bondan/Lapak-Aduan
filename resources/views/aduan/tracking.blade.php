<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-3xl px-4">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-slate-800">
                    Cek Status Aduan
                </h1>

                <p class="mt-2 text-slate-600">
                    Masukkan nomor tiket aduan Anda.
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                <!-- Form Pencarian Tiket -->
                <form
                    method="POST"
                    action="{{ route('aduan.tracking.check') }}"
                    class="flex flex-col gap-3 sm:flex-row"
                >
                    @csrf

                    <input
                        type="text"
                        name="ticket_number"
                        placeholder="Contoh: LAP-20260924-VM9RY"
                        value="{{ old('ticket_number', request('ticket_number')) }}"
                        class="flex-1 rounded-lg border-slate-300 uppercase focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800 transition"
                    >
                        Cek Status
                    </button>
                </form>

                @isset($laporan)

                    <div class="mt-8 border-t border-slate-100 pt-6 space-y-6">

                        <!-- HEADER TIKET: Nomor Tiket + Kategori & Sub Kategori Berdampingan -->
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="text-xs sm:text-sm font-bold uppercase text-slate-400 tracking-wider">
                                    NOMOR TIKET:
                                </span>

                                <span class="text-lg sm:text-xl font-extrabold text-blue-700 tracking-tight">
                                    {{ $laporan->ticket_number ?? $laporan->ticket ?? 'LAP-20260924-VM9RY' }}
                                </span>

                                <!-- BADGE KATEGORI UTAMA & SUB KATEGORI (BERDAMPINGAN) -->
                                <span class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-medium px-3 py-1.5 rounded-full border border-slate-200">
                                    <span>📁 {{ $laporan->kategori ?? 'Bidang Sumber Daya Air, Air Limbah dan Air Minum' }}</span>
                                    
                                    @if (!empty($laporan->sub_kategori))
                                        <span class="text-slate-400 font-bold">/</span>
                                        <span class="font-bold text-blue-600">{{ $laporan->sub_kategori }}</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Informasi Pengadu -->
                            <div class="text-sm text-slate-600 flex flex-wrap items-center gap-2">
                                <span class="font-bold text-slate-700">Pengadu:</span>
                                <span>{{ $laporan->nama_pengadu ?? $laporan->nama ?? $laporan->user->name ?? 'falah terfalah' }}</span>
                                <span class="text-slate-300">|</span>
                                <span class="font-bold uppercase tracking-wide text-blue-900">{{ $laporan->opd ?? $laporan->instansi ?? 'DINAS PEKERJAAN UMUM' }}</span>
                            </div>
                        </div>

                        <!-- JUDUL ADUAN -->
                        <div class="pt-2">
                            <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1">
                                JUDUL ADUAN:
                            </h3>
                            <p class="text-base font-bold text-slate-800 capitalize">
                                {{ $laporan->judul_aduan ?? $laporan->judul ?? '-' }}
                            </p>
                        </div>

                        <!-- DESKRIPSI ADUAN -->
                        <div>
                            <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1">
                                DESKRIPSI ADUAN:
                            </h3>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $laporan->isi_aduan ?? $laporan->deskripsi ?? $laporan->isi ?? '-' }}
                            </p>
                        </div>

                        <!-- BALASAN ADMIN -->
                        @if (!empty($laporan->balasan) || !empty($laporan->tanggapan))
                            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 space-y-2">
                                <div class="flex items-center gap-2 text-indigo-700 font-bold text-xs uppercase tracking-wider">
                                    <span>💬 BALASAN ADMIN:</span>
                                </div>
                                <p class="text-sm text-slate-700 font-medium">
                                    {{ $laporan->balasan ?? $laporan->tanggapan }}
                                </p>
                            </div>
                        @endif

                        <!-- TIMELINE RIWAYAT STATUS -->
                        @if (isset($laporan->riwayatStatus) && $laporan->riwayatStatus->count() > 0)
                            <div class="border-t border-slate-100 pt-6">
                                <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-4">
                                    RIWAYAT STATUS ADUAN:
                                </h3>

                                <div class="space-y-6">
                                    @foreach ($laporan->riwayatStatus->sortBy('created_at') as $riwayat)
                                        <div class="flex gap-4">
                                            <div class="flex flex-col items-center">
                                                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs text-white font-bold">
                                                    ✓
                                                </div>

                                                @if (!$loop->last)
                                                    <div class="h-full w-px bg-slate-300"></div>
                                                @endif
                                            </div>

                                            <div class="pb-2">
                                                <p class="font-bold text-slate-800 text-sm">
                                                    {{ ucfirst($riwayat->status) }}
                                                </p>

                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    {{ $riwayat->created_at->format('d M Y H:i') }}
                                                </p>

                                                @if ($riwayat->catatan)
                                                    <p class="mt-1 text-xs text-slate-600 bg-slate-100 p-2 rounded border border-slate-200">
                                                        {{ $riwayat->catatan }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>

                @elseif (request()->has('ticket_number'))

                    <div class="mt-6 rounded-lg bg-red-50 p-4 text-red-700 text-sm font-semibold">
                        Nomor tiket tidak ditemukan. Mohon periksa kembali nomor tiket Anda.
                    </div>

                @endisset

            </div>
        </div>
    </div>
</x-app-layout>