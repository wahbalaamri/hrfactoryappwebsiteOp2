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
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            //cascade on plan delete
            $table->integer('plan_id')->default(0)->constrained()->onDelete('cascade');
            // cascade on country delete
            $table->integer('country_id')->constrained()->onDelete('cascade');
            $table->integer('period');
            $table->longText('arabic_text');
            $table->longText('english_text');
            $table->longText('arabic_title');
            $table->longText('english_title');
            $table->boolean('is_active')->default(0);
            $table->integer('for')->nullable();
            $table->integer('service')->nullable();
            $table->unique(['plan_id', 'country_id', 'period','for', 'service']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
