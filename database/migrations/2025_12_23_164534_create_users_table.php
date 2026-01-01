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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();
        $table->string('password');
        $table->string('email')->unique();
        $table->string('full_name')->nullable();
        $table->decimal('total_recharge', 15, 2)->default(0);
        $table->decimal('balance', 15, 2)->default(0); // Số dư tài khoản
        $table->string('role')->default('user'); // admin hoặc user
        $table->integer('status')->default(1); // 1: active, 0: banned
        $table->string('token')->nullable(); // Thêm dòng này vào migration
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
