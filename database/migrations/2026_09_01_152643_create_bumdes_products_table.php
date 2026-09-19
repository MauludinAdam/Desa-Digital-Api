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
        Schema::create('bumdes_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bumdes_unit_id')->nullable()->constrained('bumdes_units')->onDelete('cascade');
            $table->string('name');
            $table->bigInteger('price')->nullable();
            $table->enum('type', ['product','service'])->default('product');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumdes_produks');
    }
};
