<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        $totalAduan = Laporan::where('jenis_layanan', 'aduan')->count();

        $pending = Laporan::where('jenis_layanan', 'aduan')
            ->where('status', 'pending')
            ->count();

        $diproses = Laporan::where('jenis_layanan', 'aduan')
            ->where('status', 'diproses')
            ->count();

        $selesai = Laporan::where('jenis_layanan', 'aduan')
            ->where('status', 'selesai')
            ->count();

        $ditolak = Laporan::where('jenis_layanan', 'aduan')
            ->where('status', 'ditolak')
            ->count();

        $aduanTerbaru = Laporan::where('jenis_layanan', 'aduan')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalAduan',
            'pending',
            'diproses',
            'selesai',
            'ditolak',
            'aduanTerbaru'
        ));
    }
}