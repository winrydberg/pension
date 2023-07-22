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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('claimid')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('scheme_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('department_reached')->nullable();
            $table->integer('department_reached_id')->nullable();
            $table->boolean('active')->default(true); //if claim has been cancelled
            $table->decimal('claim_amount')->nullable();
            $table->text('claim_directory')->nullable(); //root directory for claim files
            $table->text('head_directory')->nullable(); // current department claim reached directory
            $table->boolean('audited')->default(false);  // if files/claim is audited
            $table->bigInteger('auditor_id')->nullable(); 
            $table->string('audited_by')->nullable(); // name of user that audited he claim
            $table->boolean('has_issue')->default(false);
            $table->boolean('processed')->default(false); //
            $table->bigInteger('payment_id')->nullable();
            $table->longText('invalid_reason')->nullable();
            $table->bigInteger('claim_state_id')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
