<?php

namespace Database\Seeders;

use App\Models\Developers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Developers::insert([
            [
                'name' => "Dev1",
                'level' => 1,
            ],
            [
                'name' => "Dev2",
                'level' => 2,
            ],
            [
                'name' => "Dev3",
                'level' => 3,
            ],
            [
                'name' => "Dev4",
                'level' => 4,
            ],
            [
                'name' => "Dev5",
                'level' => 5,
            ]
        ]);
    }
}
