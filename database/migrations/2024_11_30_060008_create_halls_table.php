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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('hall_name');
            $table->string('hall_address');
            // $table->integer('seat_capacity');
            //$table->integer('premium_seats');
            $table->integer('phone_number');
            $table->string('normal_seat_row');
            $table->string('normal_seat_column');  
            $table->string('premium_seat_row');
            $table->string('premium_seat_column'); 
            $table->string('premium_seat_price');
            $table->string('normal_seat_price');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
