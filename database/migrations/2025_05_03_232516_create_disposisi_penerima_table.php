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
            // Foreign keys
            $table->unsignedBigInteger('disposisi_id');
            $table->unsignedBigInteger('user_id');

            // Pivot attributes
            $table->boolean('status_tugas')->default(false);
            $table->text('catatan_balasan')->nullable();
            $table->timestamps();

            // Composite primary key
            $table->primary(['disposisi_id', 'user_id']);

            // Foreign constraints
            $table->foreign('disposisi_id')
                ->references('id_disposisi')
                ->on('disposisi')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Optional indexes for performance
            $table->index('disposisi_id');
            $table->index('user_id');
            $table->index('status_tugas');
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
