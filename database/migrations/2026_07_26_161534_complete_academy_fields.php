<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('courses', 'short_description')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->text('short_description')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'featured_image')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('featured_image')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'gallery')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->json('gallery')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'duration')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('duration')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'delivery_mode')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('delivery_mode')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'schedule')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('schedule')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'location')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('location')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'fee')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->decimal('fee', 15, 2)->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'currency')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('currency', 10)->default('RWF');
            });
        }

        if (! Schema::hasColumn('courses', 'start_date')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->date('start_date')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'application_deadline')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->date('application_deadline')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'max_students')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedInteger('max_students')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'requirements')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->text('requirements')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'outcomes')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->text('outcomes')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'curriculum')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->json('curriculum')->nullable();
            });
        }

        if (! Schema::hasColumn('courses', 'is_featured')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false);
            });
        }

        if (! Schema::hasColumn('courses', 'views')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0);
            });
        }

        if (! Schema::hasColumn('training_applications', 'course_id')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->foreignId('course_id')
                    ->nullable()
                    ->constrained('courses')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('training_applications', 'application_number')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('application_number')->nullable()->unique();
            });
        }

        if (! Schema::hasColumn('training_applications', 'full_name')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('full_name')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'email')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('email')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'phone')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('phone')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'gender')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('gender')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'date_of_birth')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->date('date_of_birth')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'education_level')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('education_level')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'current_occupation')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('current_occupation')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'address')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->text('address')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'motivation')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->text('motivation')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'experience')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->text('experience')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'preferred_schedule')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('preferred_schedule')->nullable();
            });
        }

        if (! Schema::hasColumn('training_applications', 'status')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->string('status')->default('pending');
            });
        }

        if (! Schema::hasColumn('training_applications', 'admin_notes')) {
            Schema::table('training_applications', function (Blueprint $table) {
                $table->text('admin_notes')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty to avoid removing pre-existing CMS data.
    }
};
