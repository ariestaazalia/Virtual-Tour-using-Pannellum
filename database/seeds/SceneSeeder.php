<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SceneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scenes')->insert([
            [
                'id' => 1,
                'title' => 'Gedung A',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624513272.jpg',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'title' => 'Lantai 1 Gedung A',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624513329.jpg',
                'status' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'title' => 'Lantai 2 Gedung A',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624513386.jpg',
                'status' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'title' => 'Aula Gedung A',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624513478.jpg',
                'status' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'title' => 'Gedung E',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624517758.jpg',
                'status' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'title' => 'Gedung F',
                'type' => 'equirectangular',
                'hfov' => 110.00,
                'yaw' => 0.00,
                'pitch' => 0.00,
                'image' => '1624520329.jpg',
                'status' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
