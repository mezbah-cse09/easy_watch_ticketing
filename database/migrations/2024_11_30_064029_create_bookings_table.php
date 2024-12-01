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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('seats');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger(column: 'user_id');
            $table->foreign('ticket_id')->references(columns: 'id')->on('tickets')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('user_id')->references(columns: 'id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
