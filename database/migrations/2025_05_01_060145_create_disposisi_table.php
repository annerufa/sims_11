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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id('id_disposisi');
            $table->unsignedBigInteger('surat_masuk_id');
            $table->text('perintah')->nullable();
            $table->text('catatan')->nullable();
            $table->date('tanggal_disposisi')->nullable();
            $table->timestamps();

            $table->foreign('surat_masuk_id')
                ->references('id_sm')->on('surat_masuk')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
