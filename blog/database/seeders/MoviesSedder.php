<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MoviesSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $json = Storage::disk('local')->get('/data/movies.json');
        $movies = json_decode($json, true);

        foreach ($movies as $movie) {
            # code...
            Movie::query()->updateOrCreate([
                'title' => $movie['title'],
                'synopsis' => $movie['synopsis'],
                'trailerUrl' => $movie['trailerUrl'],
                'imgUrl' => $movie['imgUrl'],
                'rating' => $movie['rating'],
                'genreId' => $movie['genreId'],
            ]);
        }
    }
}
