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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('payment_id')->nullable();
            $table->string('user_id')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'paypal'])->default('cash');
            $table->string('transaction_pin')->nullable();
            $table->boolean('is_made_by')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
