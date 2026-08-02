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
        Schema::create('citizens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('family_card_id')->nullable()->constrained('family_cards')->cascadseOnDelete();
            $table->string('full_name');
            $table->string('nik', 16)->unique();
            $table->enum('gender',['male','female']);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->foreignUuid('occupation_id')->nullable()->constrained('occupations')->nullOnDelete();
            $table->foreignUuid('religion_id')->nullable()->constrained('religions')->nullOnDelete();
            $table->foreignUuid('education_id')->nullable()->constrained('educations')->nullOnDelete();
            $table->enum('marital_status',['single','married','widower','widow']);
            $table->enum('blood_type',['A','B','AB','O'])->nullable();
            $table->string('email')->nullable();
            $table->enum('nationality',['wni','wna'])->default('wni');
            $table->enum('status',['active','moved','deceased'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
