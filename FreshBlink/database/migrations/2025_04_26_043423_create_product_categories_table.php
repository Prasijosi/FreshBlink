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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('product_category_name');
            $table->text('description')->nullable();
            $table->string('product_category_image')->nullable();
            $table->date('created_on')->nullable();
            $table->date('updated_on')->nullable();
            $table->timestamps();
        });

        // Now add the foreign key constraint to products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key first
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);
        });
        
        Schema::dropIfExists('product_categories');
    }
};
