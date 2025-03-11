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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->string('catatan')->nullable();
            $table->string('keterangan_presensi');
            $table->date('tanggal');
            $table->string('waktu_datang');
            $table->string('waktu_pulang')->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
