<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\GenresSedder;
use Database\Seeders\MoviesSedder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(GenresSedder::class);
        $this->call(MoviesSedder::class);
    }
}
