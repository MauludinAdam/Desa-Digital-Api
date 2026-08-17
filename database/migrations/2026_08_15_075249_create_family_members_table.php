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
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('family_card_id')->constrained('family_cards')->cascadeOnDelete();
            $table->foreignUuid('citizen_id')->constrained('citizens')->cascadeOnDelete();
            $table->enum('relationship',['head_of_family','wife','husband','child','parent','other']);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['family_card_id','citizen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_member');
    }
};
