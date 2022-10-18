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
        // Schedule::factory(5)->create();
        $this->call(SheetTableSeeder::class);

        // 手順書になかったやつ､テストの時にはコメントアウト
        // $this->call(ReservationSeeder::class);
    }
}
