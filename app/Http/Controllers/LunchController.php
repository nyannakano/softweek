<?php

namespace App\Http\Controllers;

use App\Services\LunchService;
use Illuminate\Http\Request;

class LunchController extends Controller
{
    protected LunchService $lunchService;

    public function __construct(LunchService $lunchService)
    {
        $this->lunchService = $lunchService;
    }

    public function createLunch(Request $request)
    {
        $data = $request->all();

        $lunch = $this->lunchService->createLunch($data);

        return response()->json([
            'lunch' => $lunch,
            'message' => 'Lunch created successfully',
        ]);
    }

    public function updateLunch(Request $request)
    {
        $data = $request->all();

        $lunch = $this->lunchService->updateLunch($data);

        if ($lunch) {
            return response()->json([
                'lunch' => $lunch,
                'message' => 'Lunch updated successfully',
            ]);
        }

        return response()->json([
            'message' => 'Error updating lunch',
        ], 500);
    }

    public function deleteLunch(Request $request)
    {
        $data = $request->all();

        $result = $this->lunchService->deleteLunch($data);

        if ($result) {
            return response()->json([
                'message' => 'Lunch deleted successfully',
            ]);
        }

        return response()->json([
            'message' => 'Error deleting lunch',
        ], 500);
    }
}
