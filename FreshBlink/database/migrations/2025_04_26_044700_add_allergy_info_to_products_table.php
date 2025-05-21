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
        Schema::table('products', function (Blueprint $table) {
            $table->text('allergy_info')->nullable()->after('stock_no');
            $table->boolean('allergen_free')->default(false)->after('allergy_info');
            $table->boolean('may_contain_allergens')->default(false)->after('allergen_free');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['allergy_info', 'allergen_free', 'may_contain_allergens']);
        });
    }
}; 