<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_perbaikan', function (Blueprint $table) {
            $table->id('id_catatan');
            $table->foreignId('id_laporan')->constrained('laporan_kerusakan','id_laporan')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users','id_user')->cascadeOnDelete();
            $table->text('catatan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_perbaikan');
    }
};
