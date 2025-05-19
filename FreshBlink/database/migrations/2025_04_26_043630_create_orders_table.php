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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cart_id')->nullable()->constrained('carts');
            $table->string('status')->default('pending');
            $table->decimal('total_order', 10, 2);
            $table->string('collection_slot_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('transaction_pin')->nullable();
            $table->string('total_amount')->nullable();
            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'paypal'])->default('cash');
            $table->string('order_product')->nullable(); // Relation to order_products table
            $table->integer('no_of_product')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('points_discount', 10, 2)->default(0);
            $table->string('order_type')->nullable();
            $table->date('slot_date')->nullable();
            $table->time('time_details')->nullable();
            $table->boolean('required_slot')->default(false);
            $table->boolean('is_placed')->default(false);
            $table->boolean('is_received')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
