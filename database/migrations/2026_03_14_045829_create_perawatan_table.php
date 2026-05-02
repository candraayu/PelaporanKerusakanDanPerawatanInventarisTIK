<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perawatan', function (Blueprint $table) {
            $table->id('id_perawatan');
            $table->foreignId('id_inventaris')->constrained('inventaris','id_inventaris')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users','id_user')->cascadeOnDelete();
            $table->date('tanggal_perawatan');
            $table->string('jenis_perawatan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perawatan');
    }
};
