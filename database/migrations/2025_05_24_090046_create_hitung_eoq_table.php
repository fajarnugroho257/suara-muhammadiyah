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
        Schema::create('hitung_eoq', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->string('eoq_nilai', 25)->nullable();
            $table->string('eoq_pesanan', 25)->nullable();
            $table->string('eoq_siklus', 25)->nullable();
            $table->string('eoq_biaya', 25)->nullable();
            $table->string('eoq_rop', 25)->nullable();
            $table->timestamps();
            // 
            $table->foreign('produk_id')->references('id')->on('produk')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_eoq');
    }
};
