<?php

namespace App\Services;

use App\Models\Day;
use App\Models\Event;
use App\Models\Lunch;
use App\Models\Subscription;
use App\Models\TypeSubscription;

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
            'slots' => $data['slots'],
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

    public function getEventsHome($dayId): array
    {
        return Event::where('day_id', $dayId)->get()->toArray();
    }

    public function getLunches($type): array
    {
        return Lunch::where('type', $type)->get()->toArray();
    }

    public function getEventsPerDay(): array
    {
        list($tuesday_all_night_id, $tuesday_first_half_id, $tuesday_second_half_id, $wednesday_all_night_id, $wednesday_first_half_id, $wednesday_second_half_id, $thursday_all_night_id, $thursday_first_half_id, $thursday_second_half_id) = $this->getDaysIds();

        return [
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

    public function getEventsPerDayHome(): array
    {
        list($tuesday_all_night_id, $tuesday_first_half_id, $tuesday_second_half_id, $wednesday_all_night_id, $wednesday_first_half_id, $wednesday_second_half_id, $thursday_all_night_id, $thursday_first_half_id, $thursday_second_half_id) = $this->getDaysIds();

        return [
            'tuesday_all_night' => $this->getEventsHome($tuesday_all_night_id),
            'tuesday_first_half' => $this->getEventsHome($tuesday_first_half_id),
            'tuesday_second_half' => $this->getEventsHome($tuesday_second_half_id),
            'wednesday_all_night' => $this->getEventsHome($wednesday_all_night_id),
            'wednesday_first_half' => $this->getEventsHome($wednesday_first_half_id),
            'wednesday_second_half' => $this->getEventsHome($wednesday_second_half_id),
            'thursday_all_night' => $this->getEventsHome($thursday_all_night_id),
            'thursday_first_half' => $this->getEventsHome($thursday_first_half_id),
            'thursday_second_half' => $this->getEventsHome($thursday_second_half_id),
        ];
    }

    public function getMetrics()
    {
        $total_subscriptions = (Subscription::where('status', 'paid')->count());
        $companies = 18;
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

    /**
     * @return array
     */
    public function getDaysIds(): array
    {
        $tuesday_all_night_id = Day::where('name', 'tuesday')->where('period', 'all_day')->first()->id;
        $tuesday_first_half_id = Day::where('name', 'tuesday')->where('period', 'first_half')->first()->id;
        $tuesday_second_half_id = Day::where('name', 'tuesday')->where('period', 'second_half')->first()->id;
        $wednesday_all_night_id = Day::where('name', 'wednesday')->where('period', 'all_day')->first()->id;
        $wednesday_first_half_id = Day::where('name', 'wednesday')->where('period', 'first_half')->first()->id;
        $wednesday_second_half_id = Day::where('name', 'wednesday')->where('period', 'second_half')->first()->id;
        $thursday_all_night_id = Day::where('name', 'thursday')->where('period', 'all_day')->first()->id;
        $thursday_first_half_id = Day::where('name', 'thursday')->where('period', 'first_half')->first()->id;
        $thursday_second_half_id = Day::where('name', 'thursday')->where('period', 'second_half')->first()->id;
        return array($tuesday_all_night_id, $tuesday_first_half_id, $tuesday_second_half_id, $wednesday_all_night_id, $wednesday_first_half_id, $wednesday_second_half_id, $thursday_all_night_id, $thursday_first_half_id, $thursday_second_half_id);
    }

    public function getEventTypes()
    {
        return TypeSubscription::select(['id', 'name', 'description'])->get();
    }
}
