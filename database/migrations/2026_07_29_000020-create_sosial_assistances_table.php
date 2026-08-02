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
        Schema::create('sosial_assistances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('thumbnail');
            $table->string('name');
            $table->foreignUuid('category_id')->constrained('sosial_assistance_categories')->OnDelete('cascade');
            $table->decimal('amount');
            $table->string('provider');
            $table->longText('description');
            $table->boolean('is_available');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosial_assistances');
    }
};
