<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Aduan::query();

        // 1. FILTER TAHUN STRICT BASED ON TANGGAL ADUAN / CREATED_AT
        $tahun = $request->input('tahun') ?? $request->input('tahun_aduan');

        if (!empty($tahun) && $tahun !== 'Semua Tahun' && $tahun !== '') {
            // Gunakan whereYear ketat pada kolom tanggal aduan / created_at
            $query->where(function ($q) use ($tahun) {
                $q->whereYear('tanggal_aduan', $tahun)
                  ->orWhere(function ($sub) use ($tahun) {
                      $sub->whereNull('tanggal_aduan')
                          ->whereYear('created_at', $tahun);
                  });
            });
        }

        // 2. FILTER STATUS
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        // 3. FILTER PENCARIAN TEKS (Pencarian Tiket, Judul, Deskripsi, Lokasi)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('ticket_number', 'like', "%{$q}%")
                    ->orWhere('judul_aduan', 'like', "%{$q}%")
                    ->orWhere('isi_aduan', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        $aduan = $query->orderByRaw('COALESCE(tanggal_aduan, created_at) DESC')
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar tahun unik dari data aduan secara fleksibel
        $listTahun = Aduan::selectRaw('YEAR(COALESCE(tanggal_aduan, created_at)) as tahun')
            ->whereNotNull('tanggal_aduan')
            ->orWhereNotNull('created_at')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->filter();

        return view('admin.aduan.index', compact('aduan', 'listTahun'));
    }
}