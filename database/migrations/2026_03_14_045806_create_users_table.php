<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->foreignId('id_kecamatan')->nullable()->constrained('kecamatan','id_kecamatan')->cascadeOnDelete();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['admin','kabid','operator']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
