<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\Day;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $friday = Day::where('name', 'friday')->where('period', 'all_day')->first();
        $monday = Day::where('name', 'monday')->where('period', 'all_day')->first();

        Configuration::create([
            'opening_day_id' => $monday->id,
            'happy_hour_day_id' => $friday->id,
        ]);
    }
}
