<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('courses', 'description')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->longText('description')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'meta_title')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('meta_title')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'meta_description')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->text('meta_description')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'is_published')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_published')->default(false);
            });
        }

        if (! Schema::hasColumn('courses', 'sort_order')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0);
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty to protect existing CMS data.
    }
};
