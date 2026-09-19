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
    Schema::table('citizens', function (Blueprint $table) {
        $table->dropForeign('citizens_religion_id_foreign');
    });

    Schema::table('citizens', function (Blueprint $table) {
        $table->string('religion')->nullable()->change();
    });
}
};
