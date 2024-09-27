<?php

namespace App\Http\Controllers;

use App\Services\DayService;
use Illuminate\Http\Request;

class DayController extends Controller
{
    protected DayService $dayService;

    public function __construct(DayService $dayService)
    {
        $this->dayService = $dayService;
    }

    public function createDay(Request $request)
    {
        $data = $request->all();
        $day = $this->dayService->createDay($data);

        return response()->json(['message' => 'Day created with success', 'day' => $day]);
    }

    public function updateDay(Request $request)
    {
        $data = $request->all();
        $day = $this->dayService->updateDay($data);

        return response()->json(['message' => 'Day updated with success', 'day' => $day]);
    }

    public function deleteDay(Request $request)
    {
        $data = $request->all();
        $this->dayService->deleteDay($data);

        return response()->json(['message' => 'Day deleted with success']);
    }
}
