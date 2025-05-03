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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id('id_sk');
            $table->string('pengirim');
            $table->unsignedBigInteger('tujuan'); // relasi ke tabel instansi
            $table->string('jenis_srt');
            $table->string('no_agenda')->unique();
            $table->string('file_draft')->nullable();
            $table->string('file_fiks')->nullable();
            $table->enum('status_validasi', ['belum', 'valid', 'ditolak'])->default('belum');
            $table->enum('status_surat', ['draft', 'final'])->default('draft');
            $table->date('tanggal_srt');
            $table->string('perihal');
            $table->timestamps();

            $table->foreign('tujuan')->references('id_instansi')->on('instansi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
