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
        Schema::create('retur', function (Blueprint $table) {
            $table->id();
            $table->string('pesanan_id', 10);
            $table->text('retur_alasan')->nullable();
            $table->dateTime('retur_date')->nullable();
            $table->enum('retur_st', ['yes', 'no'])->default('yes');
            $table->timestamps();// foreign key
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur');
    }
};
