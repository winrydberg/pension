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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('paid_via')->nullable();
            $table->boolean('ispaid')->nullable();
            $table->boolean('is_sent_to_bank')->nullable()->default(false);
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('claimid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('paid_via');
            $table->dropColumn('ispaid');
            $table->dropColumn('is_sent_to_bank');
            $table->dropColumn('bank_id');
            $table->dropColumn('claimid');
        });
    }
};
