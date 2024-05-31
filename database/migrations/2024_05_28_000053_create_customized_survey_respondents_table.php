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
        Schema::create('customized_survey_respondents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->uuid('employee_id');
            $table->integer('survey_type')->nullable();
            $table->integer('survey_cycle')->nullable();
            $table->boolean('send_status')->default(false);
            $table->dateTime('sent_date')->nullable();
            $table->boolean('reminder_status')->default(false);
            $table->dateTime('reminder_date')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_survey_respondents');
    }
};
