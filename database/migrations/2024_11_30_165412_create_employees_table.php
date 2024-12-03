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
        Schema::create(table: 'employees', callback: function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(column: 'user_id');
            $table->foreign(columns: 'user_id')->references(columns: 'id')->on(table: 'users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->string(column: 'first_name', length: 50);
            $table->string(column: 'last_name', length: 50);
            $table->string(column: 'national_id', length: 50)->unique();
            $table->integer(column: 'salary');
            $table->string(column: 'joining_date', length: 50);
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->timestamp(column: 'updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
