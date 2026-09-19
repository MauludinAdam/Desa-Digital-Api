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
        Schema::create('bumdes_sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice_number')->unique();
            $table->date('sale_date');
            $table->string('customer_name')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('payment_method', ['cash','transfer','qris'])->default('cash');
            $table->enum('status', ['paid','cancelled'])->default('paid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumdes_sales');
    }
};
