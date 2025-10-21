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
        Schema::create('term_ends', function (Blueprint $table) {
            $table->id();

            // Make official_id nullable and prevent cascade delete
            $table->unsignedBigInteger('official_id')->nullable();

            $table->string('name');
            $table->string('position')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('reason')->default('term_ended'); 
            $table->timestamps();

            // Set foreign key to nullOnDelete instead of cascade
            $table->foreign('official_id')
                ->references('id')
                ->on('officials')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_ends');
    }
};
