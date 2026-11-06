<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_number',
        'judul_aduan',
        'isi_aduan',
        'lokasi',
        'nama_pengadu',
        'tanggal_aduan',
        'status',
        'kategori',
        'sub_kategori',
    ];

    protected $casts = [
        'tanggal_aduan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}