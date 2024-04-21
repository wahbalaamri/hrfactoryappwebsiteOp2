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
            $table->id();
            $table->integer('client_id')->constrained()->onDelete('cascade');
            $table->integer('survey_id')->constrained()->onDelete('cascade');
            $table->integer('sector_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('comp_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('dep_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_generation')->nullable();
            $table->integer('employee_type');
            $table->string('isCandidate')->nullable()->default(false);
            $table->string('isBoard')->nullable()->default(false);
            //sent survey status
            $table->boolean('send_status')->default(false);
            //sent survey date
            $table->dateTime('sent_date')->nullable();
            //sent reminder status
            $table->boolean('reminder_status')->default(false);
            //sent reminder date
            $table->dateTime('reminder_date')->nullable();
            $table->integer('added_by');
            $table->json('acting_for')->nullable();
            //unique constraint on client_id, survey_id,sector_id,comp_id,dep_id and emp_id or mobile or email
            $table->unique(['client_id', 'survey_id','sector_id','comp_id'], 'unique_respondent');
            $table->softDeletes();
            $table->timestamps();
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
