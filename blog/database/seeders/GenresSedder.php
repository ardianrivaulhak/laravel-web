<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class GenresSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = Storage::disk('local')->get('/data/genres.json');
        $genres = json_decode($json, true);

        foreach ($genres as $genre) {
            Genre::query()->updateOrCreate([
                'name' => $genre['name'],
            ]);
        }
    }
}
