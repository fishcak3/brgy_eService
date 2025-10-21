<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('complaint_type_id')->constrained('complaint_types')->onDelete('restrict');
            $table->string('reference_no')->unique();
            $table->string('location')->nullable();

            // ✅ Expanded statuses for better tracking
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'assigned', 'in-progress', 'resolved', 'rejected'])->default('open');

            $table->text('details')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('remarks')->nullable();

            // ✅ Track when resolved
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('complaints');
    }
};
