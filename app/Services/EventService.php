<?php

namespace App\Services;

use App\Models\Day;
use App\Models\Event;
use App\Models\Lunch;
use App\Models\Subscription;

class EventService
{
    public function createEvent(array $data): Event
    {
        return Event::create([
            'day_id' => $data['day_id'],
            'title' => $data['title'],
            'speaker' => $data['speaker'],
            'company' => $data['company'],
            'type' => $data['type'],
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
        return Event::where('day_id', $dayId)->where('slots', '>', 0)->get()->toArray();
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
        $friday_all_night_id = Day::where('name', 'friday')->where('period', 'all_day')->first()->id;
        $friday_first_half_id = Day::where('name', 'friday')->where('period', 'first_half')->first()->id;
        $friday_second_half_id = Day::where('name', 'friday')->where('period', 'second_half')->first()->id;

        return [
            'monday' => $this->getEvents($monday_id),
            'tuesday_all_night' => $this->getEvents($tuesday_all_night_id),
            'tuesday_first_half' => $this->getEvents($tuesday_first_half_id),
            'tuesday_second_half' => $this->getEvents($tuesday_second_half_id),
            'wednesday_all_night' => $this->getEvents($wednesday_all_night_id),
            'wednesday_first_half' => $this->getEvents($wednesday_first_half_id),
            'wednesday_second_half' => $this->getEvents($wednesday_second_half_id),
            'friday_all_night' => $this->getEvents($friday_all_night_id),
            'friday_first_half' => $this->getEvents($friday_first_half_id),
            'friday_second_half' => $this->getEvents($friday_second_half_id),
        ];
    }

    public function getMetrics()
    {
        $total_subscriptions = Subscription::where('status', 'paid')->count();
        $companies = Event::select('company')->distinct()->count();
        $speakers = Event::select('speaker')->distinct()->count();
        $firstHalfDays = Day::where('period', 'first_half')->pluck('id');
        $secondHalfDays = Day::where('period', 'second_half')->pluck('id');
        $allNight = Day::where('period', 'all_day')->pluck('id');

        $events_half = Event::whereIn('day_id', $firstHalfDays)
            ->orWhereIn('day_id', $secondHalfDays)
            ->count();

        $events_all_night = Event::whereIn('day_id', $allNight)->count();

        $hours_half = $events_half;
        $hours_all_night = $events_all_night * 3;
        $hours_total = $hours_half + $hours_all_night;

        return [
            'total_subscriptions' => $total_subscriptions,
            'companies' => $companies,
            'speakers' => $speakers,
            'hours_total' => $hours_total,
        ];
    }

    public function getEventsAsAdmin()
    {
        return Event::with('day')->get();
    }
}
