<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_inventaris')->constrained('inventaris','id_inventaris')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users','id_user')->cascadeOnDelete();
            $table->date('tanggal_laporan');
            $table->text('deskripsi_kerusakan');
            $table->string('foto')->nullable();
            $table->enum('status',['menunggu','disetujui','diproses','selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};
