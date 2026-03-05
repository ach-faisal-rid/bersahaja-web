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
        Schema::create('adzans', function (Blueprint $table) {
            $table->id();
            $table->enum('waktu', ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);
            $table->text('teks_arab');
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
        Schema::dropIfExists('adzans');
    }
};
