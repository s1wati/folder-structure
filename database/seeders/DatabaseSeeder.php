<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\FolderSeeder;

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
            FolderSeeder::class,
        ]);
    }
}
