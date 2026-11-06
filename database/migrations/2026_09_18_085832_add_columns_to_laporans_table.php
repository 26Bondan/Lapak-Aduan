<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'ticket')) {
                $table->string('ticket')->nullable()->after('ticket_number');
            }
            if (!Schema::hasColumn('laporans', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('laporans', 'email')) {
                $table->string('email')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('laporans', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('email');
            }
            if (!Schema::hasColumn('laporans', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['ticket', 'nama_lengkap', 'email', 'no_hp', 'alamat']);
        });
    }
};