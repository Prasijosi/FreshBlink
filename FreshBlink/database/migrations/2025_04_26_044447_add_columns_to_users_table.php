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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_role')->default('customer'); // customer, trader, admin
            $table->date('date_of_birth')->nullable();
            $table->string('contact_details')->nullable();
            $table->string('address')->nullable();
            $table->boolean('has')->default(false); // For schema relations
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_role',
                'date_of_birth',
                'contact_details',
                'address',
                'has'
            ]);
        });
    }
};
