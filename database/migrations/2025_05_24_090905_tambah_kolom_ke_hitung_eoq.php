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
        Schema::table('hitung_eoq', function (Blueprint $table) {
            $table->string('hitung_tahunan', 25)->after('produk_id');
            $table->string('hitung_pesan', 25)->after('produk_id');
            $table->string('hitung_simpan', 25)->after('produk_id');
            $table->string('hitung_harga_unit', 25)->after('produk_id');
            $table->string('hitung_hari_kerja', 25)->after('produk_id');
            $table->string('hitung_waktu', 25)->after('produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hitung_eoq', function (Blueprint $table) {
            //
        });
    }
};
