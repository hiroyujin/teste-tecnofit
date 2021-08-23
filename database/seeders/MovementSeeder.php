<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movement::insert([
            [
                'id' => 1,
                'name' => 'Deadlift'
            ],
            [
                'id' => 2,
                'name' => 'Back Squat'
            ],
            [
                'id' => 3,
                'name' => 'Bench Press'
            ],
        ]);
    }
}
