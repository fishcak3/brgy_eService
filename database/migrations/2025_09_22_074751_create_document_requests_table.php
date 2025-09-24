<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('request_type_id')->constrained('request_types')->onDelete('restrict');
            $table->string('reference_no')->unique();
            $table->date('requested_date')->nullable();
            $table->date('needed_date')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->decimal('fee', 8, 2)->default(0);
            $table->text('details')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down(): void {
        Schema::dropIfExists('document_requests');
    }
};
