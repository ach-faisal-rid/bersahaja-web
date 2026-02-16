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
        if (Schema::hasColumn('doas', 'hadith_sources')) {
            Schema::table('doas', function (Blueprint $table) {
                $table->dropColumn('hadith_sources');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('doas', 'hadith_sources')) {
            Schema::table('doas', function (Blueprint $table) {
                $table->json('hadith_sources')->nullable()->after('fetched_at');
            });
        }
    }
};
