<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Practice;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Reservation;
use Carbon\CarbonImmutable;

class ReservationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $count = 5;
        // for ($i = 0; $i < $count; $i++) {
        //     $movieId = $this->createMovie('表示しないタイトル'.$i)->id;
        //     Reservation::insert([
        //         'screening_date' => new CarbonImmutable('2020-01-01'),
        //         'schedule_id' => Schedule::insertGetId([
        //             'movie_id' => $movieId,
        //             'start_time' => new CarbonImmutable('2020-01-01 00:00:00'),
        //             'end_time' => new CarbonImmutable('2020-01-01 02:00:00'),
        //         ]),
        //         'sheet_id' => $i + 1,
        //         'email' => 'sample@exmaple.com',
        //         'name' => 'サンプル太郎',
        //     ]);
        // }

        for ($i = 0; $i < $count; $i++) {
            $movieId = $this->createMovie('タイトル'.$i)->id;
            Reservation::insert([
                'screening_date' => new CarbonImmutable('2050-01-01'),
                'schedule_id' => $this->createSchedule($movieId)->id,
                'sheet_id' => $i + 1,
                'email' => $i.'sample@exmaple.com',
                'name' => 'サンプル太郎'.$i,
            ]);
        }
    }

    private function createMovie(string $title): Movie
    {
        $movieId = Movie::insertGetId([
            'title' => $title,
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => rand(0,1),
        ]);
        return Movie::find($movieId);
    }

    private function createSchedule(int $movieId): Schedule
    {
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' => 1,
            'start_time' => new CarbonImmutable('2050-01-01 00:00:00'),
            'end_time' => new CarbonImmutable('2050-01-01 00:00:00'),
        ]);
        return Schedule::find($scheduleId);
    }
}
