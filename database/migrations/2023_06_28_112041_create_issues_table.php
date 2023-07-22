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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_ticket')->nulable(); //random issue tracker
            $table->string('title')->nullable();
            $table->text('message');
            $table->bigInteger('claim_id')->nullable();
            // $table->foreign('claim_id')->references('id')->on('claims');
            $table->boolean('resolved')->default(false);
            $table->bigInteger('department_id')->nullable(); //department issue is meant for or who should resolve the issue
            // $table->foreign('department_id')->references('id')->on('departments');
            $table->bigInteger('resolved_by')->nullable();  
            $table->bigInteger('claim_file_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('review_files_directory')->nullable();
            $table->text('resolve_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
