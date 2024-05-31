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
        Schema::create('function_practices', function (Blueprint $table) {
            $table->id();
            $table->integer('function_id')->references('id')->on('functions')->onDelete('cascade');
            $table->string('title');
            $table->string('title_ar');
            //description
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('function_practices');
    }
};
