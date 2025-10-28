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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->enum('plan', ['none', 'full', 'basic', 'pro']);
            $table->enum('billing_cycle', ['monthly', 'annual'])->nullable();
            $table->unsignedBigInteger('school_id');
            $table->string('last_payment_id')->nullable();
            $table->decimal('last_payment_amount', 10, 2)->nullable();
            $table->timestamp('last_payment_date')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
