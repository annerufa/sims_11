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
        Schema::create('disposisi_penerima', function (Blueprint $table) {
            $table->id('id_disposisi_penerima');
            $table->unsignedBigInteger('disposisi_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status_baca')->default(false);
            $table->text('catatan_balasan')->nullable();
            $table->timestamps();

            $table->foreign('disposisi_id')
                ->references('id_disposisi')->on('disposisi')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unique(['disposisi_id', 'user_id']); // Hindari duplikasi penerima untuk disposisi yang sama

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_penerima');
    }
};
