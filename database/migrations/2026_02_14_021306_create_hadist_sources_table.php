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
        Schema::create('hadist_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doa_id')->nullable()
                  ->constrained('doas')
                  ->onDelete('cascade');
            $table->foreignId('hadist_id')->nullable()
                  ->constrained('hadists')
                  ->onDelete('cascade');
            $table->string('book');
            $table->integer('number')->nullable();
            $table->string('narrator');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadist_sources');
    }
};
