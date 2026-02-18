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
        Schema::create('gerakan_shalats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gerakan');
            $table->integer('urutan_global')->nullable();
            $table->string('icon_url')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->enum('kategori', ['Wajib', 'Sunnah', 'makruh', 'haram'])->default('Wajib');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerakan_shalats');
    }
};
