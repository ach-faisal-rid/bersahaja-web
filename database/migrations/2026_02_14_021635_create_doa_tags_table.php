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
        Schema::create('doa_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doa_id')
                  ->constrained('doas')
                  ->onDelete('cascade');
            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['doa_id', 'tag_id']);
            $table->index('doa_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doa_tags');
    }
};
