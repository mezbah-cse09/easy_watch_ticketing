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
        Schema::create(table: 'profiles', callback: function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(column: 'user_id');
            $table->foreign(columns: 'user_id')->references(columns: 'id')->on(table: 'users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->string(column: 'profile_picture', length: 200);
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->timestamp(column: 'updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
