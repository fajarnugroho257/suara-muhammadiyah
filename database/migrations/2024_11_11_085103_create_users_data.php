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
        Schema::create('users_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 5);
            $table->string('user_alamat', 150)->nullable();
            $table->string('user_nama_lengkap', 150)->nullable();
            $table->string('user_telp', 15)->nullable();
            $table->date('user_tgl_lahir')->nullable();
            $table->enum('user_jk', ['L', 'P']);
            $table->timestamps();
            // foreign key
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_data');
    }
};
