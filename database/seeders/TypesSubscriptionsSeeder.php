<?php

namespace Database\Seeders;

use App\Models\TypeSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesSubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'price' => 100,
                'name' => 'Apenas Abertura',
                'description' => 'Terá acesso apenas à abertura do evento.',
            ],
            [
                'price' => 200,
                'name' => 'Semana Completa sem Happy Hour',
                'description' => 'Terá acesso a todos os dias do evento, exceto o Happy Hour.',
            ],
            [
                'price' => 300,
                'name' => 'Semana Completa com Happy Hour',
                'description' => 'Terá acesso a todos os dias do evento, incluindo o Happy Hour.',
            ],
        ];

        foreach ($types as $type) {
            TypeSubscription::create($type);
        }
    }
}
