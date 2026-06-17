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
        Schema::create('debts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel customers
        $table->decimal('total_amount', 12, 2);                               // Total utang
        $table->decimal('remaining_amount', 12, 2);                           // Sisa utang yang belum dibayar
        $table->enum('status', ['unpaid', 'paid'])->default('unpaid');       // Status pembayaran: unpaid (Belum Lunas), paid (Lunas)
        $table->date('debt_date');                                            // Tanggal berutang
        $table->date('due_date')->nullable();                                 // Tanggal jatuh tempo
        $table->text('notes')->nullable();                                    // Keterangan/Catatan
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
