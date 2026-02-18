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
        Schema::create('wudus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_langkah');
            $table->integer('urutan')->index();
            $table->text('deskripsi');
            $table->text('doa_arab')->nullable();
            $table->text('transliterasi')->nullable();
            $table->text('terjemahan')->nullable();
            $table->text('tips_penting')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wudus');
    }
};
