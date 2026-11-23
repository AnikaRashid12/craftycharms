<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Photos now live in product_images, so the single "image" column is no longer needed.
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::dropIfExists('product_images');
    }
};