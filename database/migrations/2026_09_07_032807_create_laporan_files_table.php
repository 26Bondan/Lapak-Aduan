<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporans')
                ->cascadeOnDelete();

            $table->string('nama_file');

            $table->string('path_file');

            $table->string('tipe_file')->nullable();

            $table->unsignedBigInteger('ukuran_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_files');
    }
};