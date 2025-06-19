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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->char('reference_no', 20)->unique();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('customer_id');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('sales');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
