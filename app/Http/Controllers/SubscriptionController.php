<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'friday' => 'required',
            'tuesday1' => 'required',
            'tuesday2' => 'required',
            'wednesday1' => 'required',
            'wednesday2' => 'required',
            'thursday1' => 'required',
            'thursday2' => 'required',
            'lunch' => 'required_if:friday,yes',
            'drink' => 'required_if:friday,yes',
        ], [
            'lunch.required_if' => 'O lanche é obrigatório caso vá participar do Happy Hour.',
            'drink.required_if' => 'A bebida é obrigatória caso vá participar do Happy Hour.',
            'friday.required' => 'O campo Sexta-feira é obrigatório.',
            'tuesday1.required' => 'O campo Terça-feira (primeiro horário) é obrigatório.',
            'tuesday2.required' => 'O campo Terça-feira (segundo horário) é obrigatório.',
            'wednesday1.required' => 'O campo Quarta-feira (primeiro horário) é obrigatório.',
            'wednesday2.required' => 'O campo Quarta-feira (segundo horário) é obrigatório.',
            'thursday1.required' => 'O campo Quinta-feira (primeiro horário) é obrigatório.',
            'thursday2.required' => 'O campo Quinta-feira (segundo horário) é obrigatório.',
        ]);

        $this->subscriptionService->subscribe($validatedData);

        return back()->with('success', 'You have successfully subscribed!');
    }
}
