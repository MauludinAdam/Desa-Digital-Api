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
        Schema::create('sosial_assistance_applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sosial_assistance_id')->nullable()->constrained('sosial_assistances')->nullOnDelete();
            $table->foreignUuid('citizen_id')->constrained('citizens')->cascadeOnDelete();
            $table->enum('bank',['bri','bni','bca','mandiri']);
            $table->bigInteger('amount');
            $table->longText('reason');
            $table->longText('rejection_reason')->nullable();
            $table->string('account_number',20)->nullable();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
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
