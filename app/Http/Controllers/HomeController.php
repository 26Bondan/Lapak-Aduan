<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Menghitung total data dengan jenis_layanan aduan
        $totalAduan = Laporan::where('jenis_layanan', 'aduan')->count();

        return view('home', compact('totalAduan'));
    }
}