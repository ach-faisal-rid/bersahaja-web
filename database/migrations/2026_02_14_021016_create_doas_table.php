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
        Schema::create('doas', function (Blueprint $table) {
            $table->id();
            $table->string('remote_id')->unique()->nullable();
            $table->foreignId('kategori_id')->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            $table->string('judul');
            $table->text('teks_arab');
            $table->text('transliterasi');
            $table->text('terjemahan');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('source')->default('local_seed');
            $table->timestamp('fetched_at')->nullable();
            $table->json('hadith_sources')->nullable(); // Untuk multiple sources
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('remote_id');
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
        
        Schema::dropIfExists('doas');
        
        // Re-enable foreign key checks
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON');
        }
    }
};
