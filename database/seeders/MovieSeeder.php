<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'movie_title' => 'The Shawshank Redemption',
                'grid_img' => 'uploads/shawshank_redemption_grid.jpg',
                'banner_img' => 'uploads/shawshank_redemption_banner.jpg',
                'genre' => 'Drama',
                'rating' => 9.3,
                'release_date' => '1994-09-22',
                'IMDb_link' => 'https://www.imdb.com/title/tt0111161/',
                'category' => 'Classic'
            ],
            [
                'movie_title' => 'The Godfather',
                'grid_img' => 'uploads/godfather_grid.jpg',
                'banner_img' => 'uploads/godfather_banner.jpg',
                'genre' => 'Crime',
                'rating' => 9.2,
                'release_date' => '1972-03-24',
                'IMDb_link' => 'https://www.imdb.com/title/tt0068646/',
                'category' => 'Classic'
            ],
            [
                'movie_title' => 'The Dark Knight',
                'grid_img' => 'uploads/dark_knight_grid.jpg',
                'banner_img' => 'uploads/dark_knight_banner.jpg',
                'genre' => 'Action',
                'rating' => 9.0,
                'release_date' => '2008-07-18',
                'IMDb_link' => 'https://www.imdb.com/title/tt0468569/',
                'category' => 'Superhero'
            ],
            [
                'movie_title' => 'Inception',
                'grid_img' => 'uploads/inception_grid.jpg',
                'banner_img' => 'uploads/inception_banner.jpg',
                'genre' => 'Sci-Fi',
                'rating' => 8.8,
                'release_date' => '2010-07-16',
                'IMDb_link' => 'https://www.imdb.com/title/tt1375666/',
                'category' => 'Sci-Fi'
            ],
            [
                'movie_title' => 'Fight Club',
                'grid_img' => 'uploads/fight_club_grid.jpg',
                'banner_img' => 'uploads/fight_club_banner.jpg',
                'genre' => 'Drama',
                'rating' => 8.8,
                'release_date' => '1999-10-15',
                'IMDb_link' => 'https://www.imdb.com/title/tt0137523/',
                'category' => 'Thriller'
            ],
            [
                'movie_title' => 'Pulp Fiction',
                'grid_img' => 'uploads/pulp_fiction_grid.jpg',
                'banner_img' => 'uploads/pulp_fiction_banner.jpg',
                'genre' => 'Crime',
                'rating' => 8.9,
                'release_date' => '1994-10-14',
                'IMDb_link' => 'https://www.imdb.com/title/tt0110912/',
                'category' => 'Classic'
            ],
            [
                'movie_title' => 'The Lord of the Rings: The Return of the King',
                'grid_img' => 'uploads/lotr_return_of_king_grid.jpg',
                'banner_img' => 'uploads/lotr_return_of_king_banner.jpg',
                'genre' => 'Adventure',
                'rating' => 8.9,
                'release_date' => '2003-12-17',
                'IMDb_link' => 'https://www.imdb.com/title/tt0167260/',
                'category' => 'Fantasy'
            ],
            [
                'movie_title' => 'Forrest Gump',
                'grid_img' => 'uploads/forrest_gump_grid.jpg',
                'banner_img' => 'uploads/forrest_gump_banner.jpg',
                'genre' => 'Drama',
                'rating' => 8.8,
                'release_date' => '1994-07-06',
                'IMDb_link' => 'https://www.imdb.com/title/tt0109830/',
                'category' => 'Drama'
            ],
            [
                'movie_title' => 'The Matrix',
                'grid_img' => 'uploads/matrix_grid.jpg',
                'banner_img' => 'uploads/matrix_banner.jpg',
                'genre' => 'Action',
                'rating' => 8.7,
                'release_date' => '1999-03-31',
                'IMDb_link' => 'https://www.imdb.com/title/tt0133093/',
                'category' => 'Sci-Fi'
            ],
            [
                'movie_title' => 'The Lion King',
                'grid_img' => 'uploads/lion_king_grid.jpg',
                'banner_img' => 'uploads/lion_king_banner.jpg',
                'genre' => 'Animation',
                'rating' => 8.5,
                'release_date' => '1994-06-15',
                'IMDb_link' => 'https://www.imdb.com/title/tt0110357/',
                'category' => 'Animation'
            ],
            [
                'movie_title' => 'Star Wars: Episode V - The Empire Strikes Back',
                'grid_img' => 'uploads/empire_strikes_back_grid.jpg',
                'banner_img' => 'uploads/empire_strikes_back_banner.jpg',
                'genre' => 'Action',
                'rating' => 8.7,
                'release_date' => '1980-05-21',
                'IMDb_link' => 'https://www.imdb.com/title/tt0080684/',
                'category' => 'Sci-Fi'
            ],
            [
                'movie_title' => 'Interstellar',
                'grid_img' => 'uploads/interstellar_grid.jpg',
                'banner_img' => 'uploads/interstellar_banner.jpg',
                'genre' => 'Sci-Fi',
                'rating' => 8.6,
                'release_date' => '2014-11-07',
                'IMDb_link' => 'https://www.imdb.com/title/tt0816692/',
                'category' => 'Sci-Fi'
            ],
            [
                'movie_title' => 'Schindler\'s List',
                'grid_img' => 'uploads/schindlers_list_grid.jpg',
                'banner_img' => 'uploads/schindlers_list_banner.jpg',
                'genre' => 'Biography',
                'rating' => 9.0,
                'release_date' => '1993-12-15',
                'IMDb_link' => 'https://www.imdb.com/title/tt0108052/',
                'category' => 'History'
            ],
            [
                'movie_title' => 'Goodfellas',
                'grid_img' => 'uploads/goodfellas_grid.jpg',
                'banner_img' => 'uploads/goodfellas_banner.jpg',
                'genre' => 'Crime',
                'rating' => 8.7,
                'release_date' => '1990-09-19',
                'IMDb_link' => 'https://www.imdb.com/title/tt0099685/',
                'category' => 'Crime'
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
