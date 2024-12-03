<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_title',
        'grid_img',
        'banner_img',
        'genre',
        'rating',
        'release_date',
        'IMDb_link',
        'category'
    ];
}
