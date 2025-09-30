<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_request_id');
            $table->text('product_url');
            $table->text('product_name')->nullable();
            $table->float('product_price')->nullable();
            $table->integer('product_quantity');
            $table->float('purchase_cost')->nullable();
            $table->foreign('order_request_id')->references('id')->on('order_requests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('order_request_products');
    }
};
