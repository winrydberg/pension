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
        Schema::create('claim_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('filename')->nullable();
            $table->string('month')->nullable();
            $table->string('foldername')->nullable();  //date represents the folder name
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('claim_id')->nullable();
            $table->boolean('has_issue')->default(false);
            $table->bigInteger('issue_id')->nullable();
            $table->string('extension')->nullable();
            $table->boolean('is_processed_file')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_files');
    }
};
