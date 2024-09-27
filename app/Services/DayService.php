<?php

namespace App\Services;

use App\Models\Day;

class DayService
{
    public function createDay($data)
    {
        return Day::create([
            'period_id' => $data['period'],
            'name' => $data['name'],
        ]);
    }

    public function updateDay($data)
    {
        $day = Day::find($data['id']);
        $day->period = $data['period'];
        $day->name = $data['name'];
        $day->save();

        return $day;
    }

    public function deleteDay($data)
    {
        $day = Day::find($data['id']);
        $day->delete();

        return true;
    }
}
