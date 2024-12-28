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
        Schema::create('pesanan_data', function (Blueprint $table) {
            $table->string('data_id', 15)->primary();
            $table->string('pesanan_id', 10);
            $table->string('data_jlh', 10);
            $table->timestamps();
            //
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pasanan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_data');
    }
};
