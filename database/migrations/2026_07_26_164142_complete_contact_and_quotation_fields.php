<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('contact_messages', 'name')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'email')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('email')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'phone')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('phone')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'company')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('company')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'subject')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('subject')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'message')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->longText('message')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'status')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('status')->default('new');
            });
        }

        if (! Schema::hasColumn('contact_messages', 'ip_address')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('ip_address', 45)->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'user_agent')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->text('user_agent')->nullable();
            });
        }

        if (! Schema::hasColumn('contact_messages', 'admin_notes')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->text('admin_notes')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'reference_number')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('reference_number')->nullable()->unique();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'name')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'email')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('email')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'phone')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('phone')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'company')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('company')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'service_type')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('service_type')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'project_title')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('project_title')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'project_description')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->longText('project_description')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'budget')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('budget')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'timeline')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('timeline')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'location')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('location')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'preferred_contact_method')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('preferred_contact_method')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'status')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('status')->default('new');
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'ip_address')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->string('ip_address', 45)->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'user_agent')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->text('user_agent')->nullable();
            });
        }

        if (! Schema::hasColumn('quotation_requests', 'admin_notes')) {
            Schema::table('quotation_requests', function (Blueprint $table) {
                $table->text('admin_notes')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Left empty to protect existing CMS data.
    }
};
