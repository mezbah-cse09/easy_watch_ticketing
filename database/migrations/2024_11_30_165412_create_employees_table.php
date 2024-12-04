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
            $table->unsignedBigInteger( 'user_id');
            $table->foreign( 'user_id')->references( 'id')->on(table: 'users')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->string( 'national_id', length: 50)->unique();
            $table->integer( 'salary');
            $table->string( 'joining_date', length: 50)->nullable();
            $table->timestamp( 'created_at')->useCurrent();
            $table->timestamp( 'updated_at')->useCurrent()->useCurrentOnUpdate();
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
