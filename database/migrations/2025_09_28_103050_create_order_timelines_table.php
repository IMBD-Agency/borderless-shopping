<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_request_id')->constrained('order_requests')->onDelete('cascade');
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('action_by')->nullable(); // admin, system, user
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->json('metadata')->nullable(); // Additional data like notes, location, etc.
            $table->timestamps();

            $table->index(['order_request_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('order_timelines');
    }
};
