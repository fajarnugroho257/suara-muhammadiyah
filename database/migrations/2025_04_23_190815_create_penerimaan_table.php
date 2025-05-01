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
        Schema::create('penerimaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->string('penerimaan_jumlah', 10);
            $table->date('penerimaan_tgl');
            $table->string('penerimaan_suplier', 100);
            $table->string('penerimaan_harga', 20);
            $table->timestamps();
            // foreign key
            $table->foreign('produk_id')->references('id')->on('produk')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan');
    }
};
