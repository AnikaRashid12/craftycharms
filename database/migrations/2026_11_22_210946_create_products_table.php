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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->index();                 // imported | handcraft
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);                     // selling price (customers see this)
            $table->decimal('cost_price', 10, 2)->default(0);    // admin only, used for profit
            $table->string('image')->nullable();
            $table->unsignedInteger('initial_sold')->default(0); // sold before the website, admin only
            $table->boolean('in_stock')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};