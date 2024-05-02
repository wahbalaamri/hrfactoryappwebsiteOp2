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
        Schema::create('respondents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('survey_id')->constrained()->onDelete('cascade');
            $table->integer('client_id')->constrained()->onDelete('cascade');
            $table->uuid('employee_id');
            $table->integer('survey_type')->nullable();
            $table->boolean('send_status')->default(false);
            $table->dateTime('sent_date')->nullable();
            $table->boolean('reminder_status')->default(false);
            $table->dateTime('reminder_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};
