<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use DB;
use Carbon\Carbon;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('folders')->delete();

        $folder = new Folder;
        $folder->name = 'Parent Directory';
        $folder->save();
    }
}
