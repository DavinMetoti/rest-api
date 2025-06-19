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
        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('production_price', 20, 2);
            $table->decimal('selling_price', 20, 2);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('sales_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_items');
    }
};
