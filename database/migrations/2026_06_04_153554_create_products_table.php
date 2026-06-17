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
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->string('sku')->unique();
    $table->string('name');
    $table->string('unit')->default('pcs'); // Satuan barang (pcs, kg, box, dll)
    $table->integer('stock')->default(0);
    $table->decimal('purchase_price', 12, 2); // Harga beli
    $table->decimal('selling_price', 12, 2); // Harga jual
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
