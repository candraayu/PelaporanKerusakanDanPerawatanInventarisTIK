<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id('id_inventaris');
            $table->foreignId('id_kecamatan')->constrained('kecamatan','id_kecamatan')->cascadeOnDelete();
            $table->string('kode_inventaris');
            $table->string('nama_barang');
            $table->string('kategori');
            $table->string('merk')->nullable();
            $table->string('tipe')->nullable();
            $table->year('tahun_pengadaan')->nullable();
            $table->enum('kondisi',['baik','rusak ringan','rusak berat'])->default('baik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
