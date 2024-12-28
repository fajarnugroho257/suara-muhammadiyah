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
        Schema::create('pasanan', function (Blueprint $table) {
            $table->string('pesanan_id', 10)->primary();
            $table->string('user_id', 5);
            $table->dateTime('pesanan_tgl');
            $table->enum('pesanan_st', ['waiting', 'reject', 'approve'])->default('waiting');
            $table->timestamps();
            //
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasanan');
    }
};
