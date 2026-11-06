<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    // 1. Menampilkan daftar permohonan (tabel)
    public function index()
    {
        $permohonans = Permohonan::latest()->get();
        return view('permohonan.index', compact('permohonans'));
    }

    // 2. Menampilkan form pengajuan permohonan
    public function create()
    {
        return view('permohonan.create');
    }

    // 3. Menyimpan data dari form pengajuan ke database
    public function store(Request $request)
    {
        // Normalisasi email ke huruf kecil
        $request->merge([
            'email' => strtolower(trim($request->input('email')))
        ]);

        // Validasi Data
        $validatedData = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => [
                'required',
                'email',
                'regex:/^[a-z0-9._%+-]+@gmail\.com$/',
                'max:255',
            ],
            'nomor_whatsapp'    => 'required|string|max:20',
            'alamat'            => 'required|string',
            'jenis_pemohon'     => 'required|string',
            'nama_instansi'     => 'nullable|string|max:255',
            'informasi_dimohon' => 'required|string',
            'format_informasi'  => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Maksimal 10MB
        ], [
            // Pesan Error Bahasa Indonesia
            'nama_lengkap.required'      => 'Nama lengkap wajib diisi.',
            'email.required'             => 'Email wajib diisi.',
            'email.regex'                => 'Email harus menggunakan alamat @gmail.com.',
            'nomor_whatsapp.required'    => 'Nomor HP/WhatsApp wajib diisi.',
            'alamat.required'            => 'Alamat lengkap wajib diisi.',
            'jenis_pemohon.required'     => 'Silakan pilih jenis pemohon.',
            'informasi_dimohon.required' => 'Uraian informasi yang dimohon wajib diisi.',
            'format_informasi.required'  => 'Format informasi wajib dipilih.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan informasi wajib diisi.',
            'dokumen_pendukung.mimes'    => 'Format dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen_pendukung.max'      => 'Ukuran dokumen maksimal adalah 10 MB.',
        ]);

        // Proses Upload File Dokumen Pendukung jika ada
        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('dokumen_permohonan', 'public');
            $validatedData['dokumen_pendukung'] = $path;
        }

        // Simpan Data
        Permohonan::create($validatedData);

        return redirect()
            ->route('permohonan.index')
            ->with('success', 'Permohonan berhasil dikirim!');
    }

    // 4. Update status permohonan (ACC / Tolak oleh Admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status yang dipilih tidak valid.',
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $permohonan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui!');
    }
}