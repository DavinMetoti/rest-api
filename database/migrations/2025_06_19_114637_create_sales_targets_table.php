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
        Schema::create('sales_targets', function (Blueprint $table) {
            $table->id();
            $table->date('active_date');
            $table->decimal('amount', 20, 2);
            $table->unsignedBigInteger('sales_id');

            $table->foreign('sales_id')->references('id')->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_targets');
    }
};
