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
        Schema::create('default_m_b_s', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('country_id')->constrained()->onDelete('cascade');
            $table->integer('ordering')->nullable();
            $table->integer('paren_id')->nullable()->constrained()->onDelete('cascade');
            $table->longText('description');
            $table->longText('content');
            $table->integer('user_id')->nullable();
            $table->string('language');
            $table->integer('default_MB_id');
            $table->integer('company_size');
            $table->integer('company_industry');
            $table->boolean('IsHaveLineBefore')->default(false);
            $table->boolean('IsActive');
            //softdelete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_m_b_s');
    }
};