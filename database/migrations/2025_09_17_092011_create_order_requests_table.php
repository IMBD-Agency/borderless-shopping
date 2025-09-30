<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_mobile');
            $table->text('recipient_address');
            $table->text('notes')->nullable();
            $table->enum('status', ['order_received', 'order_confirmed', 'order_processed', 'order_shipped', 'order_delivered', 'order_returned', 'order_cancelled'])->default('order_received');
            $table->string('slug');
            $table->string('tracking_number');
            $table->float('service_charge')->nullable();
            $table->float('shipping_charge')->nullable();
            $table->float('discount')->nullable();
            $table->float('total_amount')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'partially'])->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('order_requests');
    }
};
