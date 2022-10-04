<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Practice;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Practice::factory(10)->create();
    }
}
