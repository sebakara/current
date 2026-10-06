<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menu_items')
                ->cascadeOnDelete();

            $table->string('label');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('target')->default('_self');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('footer_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('section_key')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();

            $table->foreignId('footer_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('label');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('target')->default('_self');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_sections');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
