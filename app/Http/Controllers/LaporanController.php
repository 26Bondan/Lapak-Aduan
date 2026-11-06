<?php

namespace App\Http\Controllers;

use App\Imports\LaporanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Menampilkan semua aduan (dengan Filter Tahun, Status, Kategori, & Sub Kategori)
     */
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'files'])
            ->where(function ($q) {
                $q->where('jenis_layanan', 'aduan')
                  ->orWhere('jenis_layanan', 'Aduan')
                  ->orWhereNull('jenis_layanan');
            });

        // 1. Filter Tahun Aduan (Kompatibel dengan SQLite & MySQL)
        if ($request->filled('tahun') && $request->tahun !== 'Semua Tahun') {
            $tahun = $request->tahun;

            // Memprioritaskan tgl_aduan; jika tgl_aduan NULL baru mengecek created_at
            $query->where(function ($q) use ($tahun) {
                $q->whereYear('tgl_aduan', $tahun)
                  ->orWhere(function ($sub) use ($tahun) {
                      $sub->whereNull('tgl_aduan')
                          ->whereYear('created_at', $tahun);
                  });
            });
        }

        // 2. Filter Pencarian Teks (Nomor tiket, judul, lokasi)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        // 3. Filter Status
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', 'like', '%' . $request->status . '%');
        }

        // 4. Filter Kategori Bidang (Fleksibel dengan/tanpa kata 'Bidang')
        if ($request->filled('kategori')) {
            $kategori = trim($request->kategori);
            $kategoriClean = str_replace('Bidang ', '', $kategori);

            $query->where(function($q) use ($kategori, $kategoriClean) {
                $q->where('kategori', 'like', '%' . $kategori . '%')
                  ->orWhere('kategori', 'like', '%' . $kategoriClean . '%');
            });
        }

        // 5. Filter Sub Kategori (Dihapus orWhereNull agar filter bekerja presisi)
        if ($request->filled('sub_kategori')) {
            $subKategori = trim($request->sub_kategori);
            
            $words = explode(' ', $subKategori);
            $firstWord = $words[0] ?? $subKategori;

            $query->where(function($q) use ($subKategori, $firstWord) {
                $q->where('sub_kategori', 'like', '%' . $subKategori . '%')
                  ->orWhere('sub_kategori', 'like', '%' . $firstWord . '%');
            });
        }

        // Urutkan berdasarkan tanggal aduan / pembuatan terbaru
        $laporans = $query->orderBy('tgl_aduan', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('aduan.index', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['user', 'files', 'riwayatStatus.user'])
            ->findOrFail($id);

        return view('aduan.show', compact('laporan'));
    }

    public function create()
    {
        return view('aduan.create');
    }

    /**
     * Menyimpan aduan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => ['required', 'string', 'max:255'],
            'deskripsi'     => ['required', 'string'],
            'lokasi'        => ['required', 'string', 'max:255'],
            'jenis_layanan' => ['nullable', 'string'],
            'kategori'      => ['nullable', 'string'],
            'sub_kategori'  => ['nullable', 'string'],
            'email'         => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/i',
                'max:255',
            ],
            'foto_lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'files.*'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.regex'    => 'Email harus menggunakan alamat Gmail, contoh: nama@gmail.com.',
            'email.max'      => 'Email maksimal 255 karakter.',
        ]);

        $ticket = $this->generateTicketNumber();

        $laporan = DB::transaction(function () use ($request, $validated, $ticket) {
            $laporan = Laporan::create([
                'user_id'       => auth()->id(),
                'ticket_number' => $ticket,
                'jenis_layanan' => strtolower($request->input('jenis_layanan', 'aduan')),
                'kategori'      => $request->input('kategori'),
                'sub_kategori'  => $request->input('sub_kategori'),
                'media'         => 'Website',
                'opd'           => 'DINAS PEKERJAAN UMUM',
                'judul'         => $validated['judul'],
                'deskripsi'     => $validated['deskripsi'],
                'lokasi'        => $validated['lokasi'],
                'status'        => 'pending',
                'tgl_aduan'     => now(),
            ]);

            if (method_exists($laporan, 'riwayatStatus')) {
                $laporan->riwayatStatus()->create([
                    'status'  => 'pending',
                    'catatan' => 'Aduan berhasil dikirim dan menunggu verifikasi.',
                    'user_id' => auth()->id(),
                ]);
            }

            if ($request->hasFile('foto_lampiran') && method_exists($laporan, 'files')) {
                $file = $request->file('foto_lampiran');
                $path = $file->store('laporan/' . $laporan->id, 'public');
                $laporan->files()->create([
                    'nama_file'   => $file->getClientOriginalName(),
                    'path_file'   => $path,
                    'tipe_file'   => $file->getMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }

            if ($request->hasFile('files') && method_exists($laporan, 'files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('laporan/' . $laporan->id, 'public');
                    $laporan->files()->create([
                        'nama_file'   => $file->getClientOriginalName(),
                        'path_file'   => $path,
                        'tipe_file'   => $file->getMimeType(),
                        'ukuran_file' => $file->getSize(),
                    ]);
                }
            }

            return $laporan;
        });

        return redirect()
            ->route('aduan.index')
            ->with('success', 'Aduan berhasil dikirim dengan Nomor Tiket: ' . $laporan->ticket_number);
    }

    private function generateTicketNumber(): string
    {
        do {
            $ticket = 'LAP-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Laporan::where('ticket_number', $ticket)->exists());

        return $ticket;
    }

    public function success(string $ticket)
    {
        $laporan = Laporan::where('ticket_number', $ticket)->firstOrFail();

        return view('aduan.success', compact('laporan'));
    }

    public function tracking()
    {
        return view('aduan.tracking');
    }

    public function checkTracking(Request $request)
    {
        $validated = $request->validate([
            'ticket_number' => ['required', 'string'],
        ]);

        $laporan = Laporan::with('riwayatStatus')
            ->where('ticket_number', $validated['ticket_number'])
            ->first();

        return view('aduan.tracking', compact('laporan'));
    }

    public function adminDashboard()
    {
        if (strtolower(auth()->user()->role ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Admin.');
        }

        $laporans = Laporan::with(['user', 'files'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('laporans'));
    }

    /**
     * Update Status, Sub Kategori, & Balasan Aduan oleh Admin
     */
    public function updateStatus(Request $request, $id)
    {
        if (strtolower(auth()->user()->role ?? '') !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status'       => ['nullable', 'string'],
            'catatan'      => ['nullable', 'string'],
            'balasan'      => ['nullable', 'string'],
            'sub_kategori' => ['nullable', 'string'],
        ]);

        $laporan = Laporan::findOrFail($id);

        DB::transaction(function () use ($laporan, $request) {
            $dataToUpdate = [];

            // Update sub_kategori jika dikirim
            if ($request->filled('sub_kategori')) {
                $dataToUpdate['sub_kategori'] = $request->sub_kategori;
            }

            // Update status jika dikirim
            if ($request->filled('status')) {
                $dataToUpdate['status'] = strtolower($request->status);
            }

            // Update balasan jika dikirim
            $balasanText = $request->balasan ?? $request->catatan;
            if ($balasanText) {
                $dataToUpdate['balasan'] = $balasanText;
                $dataToUpdate['tgl_balasan'] = now();
            }

            if (!empty($dataToUpdate)) {
                $laporan->update($dataToUpdate);
            }

            if (method_exists($laporan, 'riwayatStatus')) {
                $laporan->riwayatStatus()->create([
                    'status'  => $request->status ? strtolower($request->status) : $laporan->status,
                    'catatan' => $balasanText ?? 'Data aduan diperbarui oleh Admin.',
                    'user_id' => auth()->id(),
                ]);
            }
        });

        return back()->with('success', 'Data aduan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (strtolower(auth()->user()->role ?? '') !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return back()->with('success', 'Aduan berhasil dihapus.');
    }

    public function importExcel(Request $request): RedirectResponse
    {
        if (strtolower(auth()->user()->role ?? '') !== 'admin') {
            abort(403);
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xls,xlsx',
                'max:20480',
            ],
        ]);

        try {
            Excel::import(
                new LaporanImport,
                $request->file('file')
            );

            return redirect()
                ->route('aduan.index')
                ->with(
                    'success',
                    'Data aduan berhasil diimport.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('aduan.index')
                ->with(
                    'error',
                    'Import gagal: ' . $e->getMessage()
                );
        }
    }
}