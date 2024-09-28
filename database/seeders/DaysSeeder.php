<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaysSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            [
                'name' =>'monday',
                'period' => 'all_day'
            ],
            [
                'name' =>'tuesday',
                'period' => 'first_half'
            ],
            [
                'name' => 'tuesday',
                'period' => 'second_half'
            ],
            [
                'name' => 'wednesday',
                'period' => 'first_half'
            ],
            [
                'name' => 'wednesday',
                'period' => 'second_half'
            ],
            [
                'name' => 'thursday',
                'period' => 'first_half'
            ],
            [
                'name' => 'thursday',
                'period' => 'second_half'
            ],
            [
                'name' => 'friday',
                'period' => 'all_day'
            ],
            [
                'name' =>'tuesday',
                'period' => 'all_day'
            ],
            [
                'name' =>'wednesday',
                'period' => 'all_day'
            ],
            [
                'name' => 'thursday',
                'period' => 'all_day'
            ]
        ];

        foreach ($days as $day) {
            Day::create($day);
        }
    }
}
