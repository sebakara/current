<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general')->index();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('text');
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('template')->default('default');
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('section_key')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->json('data')->nullable();
            $table->string('layout')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('background_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->string('text_position')->default('left');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('type')->default('general');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('process')->nullable();
            $table->string('icon')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('features')->nullable();
            $table->json('specifications')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('video_url')->nullable();
            $table->string('datasheet')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('currency', 10)->default('RWF');
            $table->boolean('show_price')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();
            $table->date('completed_at')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->json('technologies')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('code')->nullable()->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('overview')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('learning_outcomes')->nullable();
            $table->string('duration')->nullable();
            $table->string('schedule')->nullable();
            $table->decimal('fee', 15, 2)->nullable();
            $table->string('currency', 10)->default('RWF');
            $table->string('featured_image')->nullable();
            $table->json('modules')->nullable();
            $table->date('application_deadline')->nullable();
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->unsignedInteger('available_places')->nullable();
            $table->boolean('applications_open')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('training_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('application_number')->unique();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('education_level')->nullable();
            $table->text('experience')->nullable();
            $table->text('motivation')->nullable();
            $table->string('document')->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('department')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('organization')->nullable();
            $table->string('type')->default('client');
            $table->text('content');
            $table->string('photo')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->string('department')->nullable();
            $table->text('message');
            $table->string('status')->default('new')->index();
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('internal_notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('request_type')->nullable();
            $table->foreignId('service_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('project_description');
            $table->decimal('estimated_budget', 15, 2)->nullable();
            $table->string('currency', 10)->default('RWF');
            $table->date('required_by')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('new')->index();
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_requests');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('training_applications');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_categories');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('settings');
    }
};
