<?php

namespace App\Services;

use App\Models\Day;
use App\Models\Event;
use App\Models\Lunch;

class EventService
{
    public function createEvent(array $data): Event
    {
        return Event::create([
            'day_id' => $data['day_id'],
            'title' => $data['title'],
            'company' => $data['company'],
        ]);
    }

    public function updateEvent(array $data): ?Event
    {
        try {
            $event = Event::find($data['id']);

            $event->update([
                'day_id' => $data['day_id'],
                'title' => $data['title'],
                'company' => $data['company'],
            ]);

            return $event;
        } catch (\Exception $e) {
            \Log::error('Error updating event: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteEvent($data): bool
    {
        try {
            Event::destroy($data['id']);

            return true;
        } catch (\Exception $e) {
            \Log::error('Error deleting event: ' . $e->getMessage());
            return false;
        }
    }

    public function getEvents($dayId): array
    {
        return Event::where('day_id', $dayId)->get()->toArray();
    }

    public function getLunches($type): array
    {
        return Lunch::where('type', $type)->get()->toArray();
    }

    public function getEventsPerDay(): array
    {
        $monday_id = Day::where('name', 'monday')->first()->id;
        $tuesday_all_night_id = Day::where('name', 'tuesday')->where('period', 'all_day')->first()->id;
        $tuesday_first_half_id = Day::where('name', 'tuesday')->where('period', 'first_half')->first()->id;
        $tuesday_second_half_id = Day::where('name', 'tuesday')->where('period', 'second_half')->first()->id;
        $wednesday_all_night_id = Day::where('name', 'wednesday')->where('period', 'all_day')->first()->id;
        $wednesday_first_half_id = Day::where('name', 'wednesday')->where('period', 'first_half')->first()->id;
        $wednesday_second_half_id = Day::where('name', 'wednesday')->where('period', 'second_half')->first()->id;
        $thursday_all_night_id = Day::where('name', 'thursday')->where('period', 'all_day')->first()->id;
        $thursday_first_half_id = Day::where('name', 'thursday')->where('period', 'first_half')->first()->id;
        $thursday_second_half_id = Day::where('name', 'thursday')->where('period', 'second_half')->first()->id;

        return [
            'monday' => $this->getEvents($monday_id),
            'tuesday_all_night' => $this->getEvents($tuesday_all_night_id),
            'tuesday_first_half' => $this->getEvents($tuesday_first_half_id),
            'tuesday_second_half' => $this->getEvents($tuesday_second_half_id),
            'wednesday_all_night' => $this->getEvents($wednesday_all_night_id),
            'wednesday_first_half' => $this->getEvents($wednesday_first_half_id),
            'wednesday_second_half' => $this->getEvents($wednesday_second_half_id),
            'thursday_all_night' => $this->getEvents($thursday_all_night_id),
            'thursday_first_half' => $this->getEvents($thursday_first_half_id),
            'thursday_second_half' => $this->getEvents($thursday_second_half_id),
        ];
    }
}
