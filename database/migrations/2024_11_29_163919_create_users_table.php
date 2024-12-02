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
        Schema::create(table: 'users', callback: function (Blueprint $table) {
            $table->id();
            $table->string(column: 'first_name', length: 50);
            $table->string(column: 'last_name', length: 50);
            $table->string(column: 'email', length: 50)->unique();
            $table->string(column: 'mobile_no', length: 15);
            $table->string(column: 'password', length: 50);
            $table->string(column: 'otp', length: 10);
            $table->enum(column: 'role', allowed: ['customer', 'admin', 'employee'])->default('customer');
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->timestamp(column: 'updated_at')->useCurrent()->useCurrentOnUpdate();
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
