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
        Schema::create('bumdes_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bumdes_id')->constrained('bumdes')->cascadeOnDelete();
            $table->string('name');
            $table->string('business_type')->nullable();
            $table->text('description')->nullable();
            $table->date('established_year')->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumdes_units');
    }
};
