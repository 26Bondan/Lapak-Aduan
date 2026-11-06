<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('judul_aduan');
            $table->text('isi_aduan');
            $table->string('kategori')->nullable();
            $table->string('sub_kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamp('tanggal_aduan')->nullable(); // Kolom khusus untuk tarikh aduan sebenar
            $table->enum('status', ['pending', 'diproses', 'selesai', 'proses'])->default('pending');
            $table->text('balasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};