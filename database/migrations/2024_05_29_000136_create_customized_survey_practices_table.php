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
        Schema::create('customized_survey_practices', function (Blueprint $table) {
            $table->id();
            $table->integer('function_id')->references('id')->on('customized_survey_functions')->onDelete('cascade');
            $table->string('title');
            $table->string('title_ar');
            $table->string('title_in')->nullable();
            $table->string('title_urdo')->nullable();
            $table->string('title_fr')->nullable();
            $table->string('title_sp')->nullable();
            $table->string('title_bngla')->nullable();
            $table->string('title_tr')->nullable();
            $table->string('title_pr')->nullable();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_survey_practices');
    }
};
