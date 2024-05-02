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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('client_id')->constrained()->onDelete('cascade');
            $table->integer('sector_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('comp_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('dep_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_generation')->nullable();
            $table->string('position')->nullable();
            $table->integer('employee_type');
            $table->string('isCandidate')->nullable()->default(false);
            $table->string('isBoard')->nullable()->default(false);
            $table->json('acting_for')->nullable();
            $table->boolean('is_hr_manager')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('added_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
