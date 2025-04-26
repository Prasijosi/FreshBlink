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
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shop_id')->constrained('shops');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->integer('min_order')->nullable();
            $table->integer('max_order')->nullable();
            $table->string('product_image')->nullable();
            $table->decimal('stock_no', 10)->nullable();
            $table->timestamps();
            
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('set null');
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
