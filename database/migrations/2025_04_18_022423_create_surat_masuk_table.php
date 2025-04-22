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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id('id_sm');
            // pengirim
            $table->foreignId('id_pengirim')
                ->constrained(
                    table: 'instansi',
                    column: 'id_instansi'
                )
                ->onDelete('cascade');
            $table->string('sifat_srt');
            $table->string('jenis_srt');
            $table->string('nomor_srt');
            $table->date('tanggal_srt');
            $table->date('tanggal_terima');
            $table->string('perihal');
            $table->string('file')->nullable();
            $table->text('keterangan')->nullable();
            // $table->string('lampiran')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
