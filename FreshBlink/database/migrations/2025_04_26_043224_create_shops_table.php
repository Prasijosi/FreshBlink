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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trader_id');
            $table->foreign('trader_id')->references('user_id')->on('traders')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('opening_hours');
            $table->string('closing_hours');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
