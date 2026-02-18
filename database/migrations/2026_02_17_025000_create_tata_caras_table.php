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
        Schema::create('tata_caras', function (Blueprint $table) {
            $table->id();
            $table->string('nama_langkah');
            $table->integer('urutan')->index();
            $table->text('deskripsi');
            $table->foreignId('gerakan_id')->nullable()
                  ->constrained('gerakan_shalats')
                  ->onDelete('set null');
            $table->text('bacaan_arab')->nullable();
            $table->text('transliterasi')->nullable();
            $table->text('terjemahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tata_caras');
    }
};
