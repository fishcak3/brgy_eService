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
        Schema::create('proof_of_residency_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Example: 'Utility Bill'
            $table->string('code')->unique(); // Example: 'utility_bill'
            $table->timestamps();
        });

        DB::table('proof_of_residency_types')->insert([
            ['name' => 'Utility Bill', 'code' => 'utility_bill', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lease Agreement', 'code' => 'lease_agreement', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Barangay Record', 'code' => 'barangay_record', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Others', 'code' => 'others', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proof_of_residency_types');
    }
};
