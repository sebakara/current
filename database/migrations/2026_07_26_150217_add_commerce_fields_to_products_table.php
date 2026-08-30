<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'sale_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('sale_price', 15, 2)
                    ->nullable();
            });
        }

        if (! Schema::hasColumn('products', 'minimum_order_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('minimum_order_quantity')
                    ->default(1);
            });
        }

        if (! Schema::hasColumn('products', 'stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('stock_quantity')
                    ->nullable();
            });
        }

        if (! Schema::hasColumn('products', 'manage_stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('manage_stock')
                    ->default(false);
            });
        }

        if (! Schema::hasColumn('products', 'allow_backorders')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('allow_backorders')
                    ->default(false);
            });
        }

        if (! Schema::hasColumn('products', 'cart_enabled')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('cart_enabled')
                    ->default(true);
            });
        }

        if (! Schema::hasColumn('products', 'whatsapp_order_enabled')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('whatsapp_order_enabled')
                    ->default(true);
            });
        }

        if (! Schema::hasColumn('products', 'options')) {
            Schema::table('products', function (Blueprint $table) {
                $table->json('options')
                    ->nullable();
            });
        }
    }

    public function down(): void
    {
        $columns = [
            'sale_price',
            'minimum_order_quantity',
            'stock_quantity',
            'manage_stock',
            'allow_backorders',
            'cart_enabled',
            'whatsapp_order_enabled',
            'options',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('products', $column)) {
                Schema::table('products', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
