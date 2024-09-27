<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function createEvent(Request $request)
    {
        $data = $request->all();

        $event = $this->eventService->createEvent($data);

        return response()->json([
            'event' => $event,
            'message' => 'Event created successfully',
        ]);
    }

    public function updateEvent(Request $request)
    {
        $data = $request->all();

        $event = $this->eventService->updateEvent($data);

        if ($event) {
            return response()->json([
                'event' => $event,
                'message' => 'Event updated successfully',
            ]);
        }

        return response()->json([
            'message' => 'Error updating event',
        ], 500);
    }

    public function deleteEvent(Request $request)
    {
        $data = $request->all();

        $result = $this->eventService->deleteEvent($data);

        if ($result) {
            return response()->json([
                'message' => 'Event deleted successfully',
            ]);
        }

        return response()->json([
            'message' => 'Error deleting event',
        ], 500);
    }
}
