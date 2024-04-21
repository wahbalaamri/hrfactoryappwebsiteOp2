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
        Schema::create('raters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            //candidate uuid
            $table->string('candidate_id')->index('candidate_id');
            //rater uuid
            $table->string('rater_id')->index('rater_id');
            //type of rater
            $table->string('type');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raters');
    }
};
