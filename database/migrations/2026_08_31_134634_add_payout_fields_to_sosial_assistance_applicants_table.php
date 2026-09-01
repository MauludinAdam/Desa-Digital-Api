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
        Schema::table('sosial_assistance_applicants', function (Blueprint $table) {
            $table->string('payout_id')->nullable()->after('payout_status');
            $table->string('payout_reference')->nullable()->after('payout_id');
            $table->timestamp('payout_at')->nullable()->after('payout_reference');
            $table->text('payout_failure_reason')->nullbale()->after('payout_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sosial_assistance_applicants', function (Blueprint $table) {
            $table->dropColumn([
                'payout_id',
                'payout_reference',
                'payout_at',
                'payout_failure_reason'
            ]);
        });
    }
};
