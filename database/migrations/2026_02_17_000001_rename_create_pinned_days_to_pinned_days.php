<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('create_pinned_days') && !Schema::hasTable('pinned_days')) {
            Schema::rename('create_pinned_days', 'pinned_days');
        }

        if (Schema::hasTable('pinned_days') && !Schema::hasColumn('pinned_days', 'updated_at')) {
            Schema::table('pinned_days', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pinned_days') && Schema::hasColumn('pinned_days', 'updated_at')) {
            Schema::table('pinned_days', function (Blueprint $table) {
                $table->dropColumn('updated_at');
            });
        }

        if (Schema::hasTable('pinned_days') && !Schema::hasTable('create_pinned_days')) {
            Schema::rename('pinned_days', 'create_pinned_days');
        }
    }
};
