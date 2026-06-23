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
        Schema::create('sosial_assistance_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sosial_assistance_id')->constrained('sosial_assistances')->onDelete('cascade');
            $table->foreignUuid('head_of_family_id')->constrained('head_of_families')->onDelete('cascade');
            $table->enum('bank',['bri','bni','bca','mandiri']);
            $table->decimal('amount');
            $table->longText('reason');
            $table->integer('account_number');
            $table->string('proof');
            $table->enum('status',['pending','approved','rejected']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosial_assistance_recipients');
    }
};
