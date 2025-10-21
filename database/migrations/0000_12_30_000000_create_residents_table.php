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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('name')->virtualAs("CONCAT(fname, ' ', IFNULL(CONCAT(mname, ' '), ''), lname, IFNULL(CONCAT(' ', suffix), ''))");

            // Personal Info
            $table->string('phone_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->enum('civil_status', ['single', 'married', 'widowed'])->nullable();

            // Address
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street')->nullable();
            $table->string('zone')->nullable();

            // Household
            $table->string('household_id')->nullable();

            // Sectoral Info
            $table->boolean('solo_parent')->default(false);
            $table->boolean('ofw')->default(false);
            $table->boolean('is_pwd')->default(false);
            $table->boolean('is_4ps')->default(false);
            $table->boolean('out_of_school_children')->default(false);
            $table->boolean('osa')->default(false);
            $table->boolean('unemployed')->default(false);
            $table->boolean('laborforce')->default(false);
            $table->boolean('isy_isc')->default(false);

            // Senior citizen and voter info
            $table->boolean('senior_citizen')->default(false);
            $table->boolean('voter')->default(false);

            // Family details
            $table->string('mother_maiden_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
