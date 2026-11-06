<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_status_laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporans')
                ->cascadeOnDelete();

            $table->string('status', 30);

            $table->text('catatan')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_laporans');
    }
};