<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nomor_whatsapp');
            $table->text('alamat');
            $table->string('jenis_pemohon');
            $table->string('nama_instansi')->nullable(); // <-- Ditambahkan di sini (opsional/nullable)
            $table->text('informasi_dimohon');
            $table->string('format_informasi');
            $table->string('tujuan_penggunaan');
            $table->string('dokumen_pendukung')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};