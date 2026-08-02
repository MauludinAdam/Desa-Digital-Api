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
        Schema::table('family_cards', function (Blueprint $table) {
              $table->foreignUuid('head_of_family_id')->after('id')->nullable()->constrained('citizens')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_cards', function (Blueprint $table) {
            $table->dropForeign(['head_of_Family_id']);
            $table->dropColumn('head_of_family_id');
        });
    }
};
