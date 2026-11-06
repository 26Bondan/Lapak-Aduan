<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    // 1. Menampilkan daftar permohonan ke halaman tabel
    public function index()
    {
        $permohonans = Permohonan::latest()->get();
        return view('permohonan.index', compact('permohonans'));
    }

    // 2. Menampilkan halaman form permohonan informasi
    public function create()
    {
        return view('permohonan.create'); // Sesuaikan dengan nama blade form Anda
    }

    // 3. Menyimpan data dari form
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'nomor_whatsapp'     => 'required|string|max:20',
            'alamat'             => 'required|string',
            'jenis_pemohon'      => 'required|string',
            'informasi_dimohon'  => 'required|string',
            'format_informasi'   => 'required|string',
            'tujuan_penggunaan'  => 'required|string',
            'dokumen_pendukung'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('dokumen_pendukung', 'public');
            $validatedData['dokumen_pendukung'] = $path;
        }

        Permohonan::create($validatedData);

        return redirect()->route('permohonan.index')->with('success', 'Permohonan berhasil dikirim!');
    }
}