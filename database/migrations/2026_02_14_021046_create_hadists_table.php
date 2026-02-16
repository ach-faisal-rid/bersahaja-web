<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hadists', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('teks_arab');
            $table->text('transliterasi');
            $table->text('terjemah');
            $table->foreignId('kategori_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->string('audio_url')->nullable();
            $table->string('gambar_url')->nullable();
            $table->timestamps();

            $table->index('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks for SQLite
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
        }

        Schema::dropIfExists('hadists');

        // Re-enable foreign key checks
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON');
        }
    }
};
