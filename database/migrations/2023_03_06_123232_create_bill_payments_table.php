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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->double('original_amount', 8, 2)->default(0);
            $table->double('amount', 8, 2);
            $table->string('due_date');
            $table->string('payment_date');
            $table->double('interest_amount_calculated', 8, 2)->default(0);
            $table->double('fine_amount_calculated', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
    }
};
