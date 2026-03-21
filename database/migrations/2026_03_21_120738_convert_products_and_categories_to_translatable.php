<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Move existing data to JSON format (e.g. {"en": "name"})
        // Categories
        Schema::table('categories', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('slug')->change();
        });
        
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            if (!json_decode($category->name)) {
                DB::table('categories')->where('id', $category->id)->update([
                    'name' => json_encode(['en' => $category->name, 'ar' => $category->name]),
                    'slug' => json_encode(['en' => $category->slug, 'ar' => $category->slug]),
                ]);
            }
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('slug')->change();
        });

        // Products
        Schema::table('products', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('description')->nullable()->change();
        });

        $products = DB::table('products')->get();
        foreach ($products as $product) {
            if (!json_decode($product->name)) {
                DB::table('products')->where('id', $product->id)->update([
                    'name' => json_encode(['en' => $product->name, 'ar' => $product->name]),
                    'description' => json_encode(['en' => $product->description, 'ar' => $product->description]),
                ]);
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('slug')->change();
        });
    }
};
