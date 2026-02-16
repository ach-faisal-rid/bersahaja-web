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
        Schema::create('hijri_events', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->string('title');
            $table->text('description');
            $table->string('date_label');
            $table->string('color_hex');
            $table->string('icon_key');
            $table->string('source');
            $table->timestamp('fetched_at');
            $table->timestamps();
            
            $table->unique(['year', 'month', 'day', 'title']);
            $table->index(['year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hijri_events');
    }
};
