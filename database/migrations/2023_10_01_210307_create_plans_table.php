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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            // cascading service delete
            $table->integer('service')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('name_ar');
            $table->longText('delivery_mode');
            $table->longText('delivery_mode_ar');
            $table->longText('limitations');
            $table->longText('limitations_ar');
            $table->string('sample_report');
            //is_active
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
