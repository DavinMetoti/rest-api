<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('user_roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
