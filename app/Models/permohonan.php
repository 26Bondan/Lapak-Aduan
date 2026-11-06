<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_whatsapp',
        'alamat',
        'jenis_pemohon',
        'informasi_dimohon',
        'format_informasi',
        'tujuan_penggunaan',
        'dokumen_pendukung',
        'status',
    ];
}