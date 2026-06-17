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
        // Sales (transaction header)
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('sale_date')->useCurrent();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('total_profit', 12, 2)->default(0);
            $table->timestamps();
        });

        // Sale items (details)
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2); // selling price at time of sale
            $table->decimal('unit_cost', 12, 2); // purchase price at time of sale
            $table->decimal('subtotal', 12, 2);
            $table->decimal('profit', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
    }
};
