<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kecamatan', function (Blueprint $table) {
            $table->string('kode_kecamatan', 20)->after('id_kecamatan')->nullable()->unique();
            $table->string('kontak', 20)->after('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kecamatan', function (Blueprint $table) {
            $table->dropColumn(['kode_kecamatan', 'kontak']);
        });
    }
};
