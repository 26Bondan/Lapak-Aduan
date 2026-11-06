<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Data lama dari Excel tidak memiliki user_id
            $table->foreignId('user_id')
                ->nullable()
                ->change();

            // Data tambahan dari Excel 2022
            $table->dateTime('tgl_aduan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('media')->nullable();
            $table->string('opd')->nullable();
            $table->text('balasan')->nullable();
            $table->dateTime('tgl_balasan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->dateTime('tanggal_tindak_lanjut')->nullable();
            $table->unsignedTinyInteger('bintang')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_aduan',
                'kategori',
                'media',
                'opd',
                'balasan',
                'tgl_balasan',
                'tindak_lanjut',
                'tanggal_tindak_lanjut',
                'bintang',
            ]);

            $table->foreignId('user_id')
                ->nullable(false)
                ->change();
        });
    }
};