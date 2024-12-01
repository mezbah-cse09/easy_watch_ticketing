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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('movie_title');
            $table->string('grid_img');
            $table->string('banner_img') ;
            $table->Enum('genre', ['comedy', 'action', 'drama']);
            $table->float('rating', 3, 2)->nullable();
            $table->date('release_date');
            $table->Enum('category', ['scl_fi', 'adventure', 'thriller']);
            $table->string('IMDB_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
