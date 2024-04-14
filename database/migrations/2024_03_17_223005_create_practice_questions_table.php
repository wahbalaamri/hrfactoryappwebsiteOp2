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
        Schema::create('practice_questions', function (Blueprint $table) {
            $table->id();
            //cascading on practice delete
            $table->integer('practice_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->string('question_ar');
            $table->integer('respondent');
            //description
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('status');
            $table->boolean('IsENPS')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_questions');
    }
};
