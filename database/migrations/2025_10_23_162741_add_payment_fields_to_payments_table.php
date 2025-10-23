<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->default('stripe')->after('amount');
            $table->string('transaction_id')->nullable()->after('payment_method');
            $table->string('payment_status')->default('pending')->after('transaction_id');
            $table->json('metadata')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'transaction_id', 'payment_status', 'metadata']);
        });
    }
};
