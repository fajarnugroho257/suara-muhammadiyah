<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_id')->unsigned();
            $table->foreign('kategori_id')->references('id')->on('kategori')->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('produk_nama', 100)->nullable();
            $table->text('produk_deskripsi')->nullable();
            $table->string('produk_harga', 50)->nullable();
            $table->string('produk_stok', 50)->nullable();
            $table->string('produk_image')->nullable();
            $table->timestamps();
            //

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
