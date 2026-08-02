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
        Schema::create('letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('citizen_id')->constrained('citizens')->cascadeOnDelete();
            $table->foreignUuid('letter_type_id')->constrained('letter_types')->restrictOnDelete();;
            $table->string('letter_number')->nullable();
            $table->longText('purpose')->nullable();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->longText('rejection_reason')->nullable();
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->nullOnDelete('cascade');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
