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
        Schema::create('bumdes_sales_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bumdes_sales_id')->nullable()->constrained('bumdes_sales')->onDelete("cascade");
            $table->foreignUuid('bumdes_product_id')->nullable()->constrained('bumdes_products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 15, 0);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumdes_sales_items');
    }
};
