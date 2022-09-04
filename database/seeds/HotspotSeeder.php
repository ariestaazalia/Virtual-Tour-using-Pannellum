<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HotspotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotspots')->insert([
            [
                'id' => 1,
                'type' => 'scene',
                'yaw' => 5.00,
                'pitch' => 1.50,
                'info' => 'Lantai 1 Gedung A',
                'sourceScene' => 1,
                'targetScene' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'type' => 'scene',
                'yaw' => 5.00,
                'pitch' => 2.00,
                'info' => 'Lantai 2 Gedung A',
                'sourceScene' => 2,
                'targetScene' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'type' => 'scene',
                'yaw' => -65.00,
                'pitch' => 2.00,
                'info' => 'Aula Gedung A',
                'sourceScene' => 3,
                'targetScene' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'type' => 'scene',
                'yaw' => 88.00,
                'pitch' => -2.00,
                'info' => 'Gedung E',
                'sourceScene' => 1,
                'targetScene' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'type' => 'scene',
                'yaw' => -88.50,
                'pitch' => 0.00,
                'info' => 'Gedung F',
                'sourceScene' => 5,
                'targetScene' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
