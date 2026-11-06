<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermohonanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'jenis_pemohon' => 'required|string|in:perorangan,lembaga',
            'informasi_dimohon' => 'required|string',
            'format_informasi' => 'required|string|in:softcopy,hardcopy',
            'tujuan_penggunaan' => 'required|string|in:penelitian,hukum,lainnya',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'persetujuan' => 'accepted',
        ];
    }
}