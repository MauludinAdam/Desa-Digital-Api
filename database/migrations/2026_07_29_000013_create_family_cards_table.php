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
        Schema::create('family_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('family_card_number', 16)->unique();
            $table->longText('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('hamlet');
            $table->string('village');
            $table->string('district');
            $table->string('regency');
            $table->string('province');
            $table->string('postal_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_cards');
    }
};
