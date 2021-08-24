<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BookSeeder;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\TwillUserSeeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AuthorSeeder::class,
            BookSeeder::class,
            TwillUserSeeder::class,
        ]);
    }
}
