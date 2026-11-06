<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanFile extends Model
{
    protected $fillable = [
        'laporan_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }
}