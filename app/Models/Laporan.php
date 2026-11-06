<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika sesuai standar plural Laravel)
     */
    protected $table = 'laporans';

    /**
     * PERBAIKAN: Izinkan semua kolom penting dimasukkan ke database melalui Mass Assignment
     */
    protected $fillable = [
        'user_id',
        'ticket_number',
        'ticket',             // Tambahkan ini
        'nama_lengkap',       // Tambahkan ini
        'email',              // Tambahkan ini
        'no_hp',              // Tambahkan ini
        'alamat',             // Tambahkan ini
        'jenis_layanan',
        'judul',
        'deskripsi',
        'lokasi',
        'status',

        // Data Excel 2022 & Pelengkap
        'tgl_aduan',
        'kategori',
        'media',
        'opd',
        'balasan',
        'tgl_balasan',
        'tindak_lanjut',
        'tanggal_tindak_lanjut',
        'bintang',
    ];

    /**
     * Casting tipe data kolom
     */
    protected $casts = [
        'tgl_aduan' => 'datetime',
        'tgl_balasan' => 'datetime',
        'tanggal_tindak_lanjut' => 'datetime',
        'bintang' => 'integer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke File Lampiran
    public function files()
    {
        return $this->hasMany(LaporanFile::class);
    }

    // Relasi ke Riwayat Status
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusLaporan::class);
    }
}