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
            $table->string('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->integer('price');
            $table->integer('original_price')->nullable();
            $table->string('category_slug');
            $table->json('images')->nullable();
            $table->float('rating')->default(5.0);
            $table->integer('stock')->default(100);
            $table->boolean('is_popular')->default(false);
            $table->text('description')->nullable();
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
