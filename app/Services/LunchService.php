<?php

namespace App\Services;

use App\Models\Lunch;

class LunchService
{
    public function createLunch(array $data): Lunch
    {
        return Lunch::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }

    public function updateLunch(array $data): ?Lunch
    {
        try {
            $lunch = Lunch::find($data['id']);

            $lunch->update([
                'name' => $data['name'],
                'type' => $data['type'],
            ]);

            return $lunch;
        } catch (\Exception $e) {
            \Log::error('Error updating lunch: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteLunch($data): bool
    {
        try {
            Lunch::destroy($data['id']);

            return true;
        } catch (\Exception $e) {
            \Log::error('Error deleting lunch: ' . $e->getMessage());
            return false;
        }
    }
}
