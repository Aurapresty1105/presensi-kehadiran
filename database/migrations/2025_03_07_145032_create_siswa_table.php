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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); 
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelas'); 
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->string('nis');
            $table->string('jenis_kelamin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
