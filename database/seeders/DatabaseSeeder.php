<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Practice;
use App\Models\Movie;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Movie::factory(20)->create();
        Schedule::factory(20)->create();
        $this->call(SheetTableSeeder::class);
    }
}
