<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'name' => 'Joao'
            ],
            [
                'id' => 2,
                'name' => 'Jose'
            ],
            [
                'id' => 3,
                'name' => 'Paulo'
            ]
        ]);
    }
}
