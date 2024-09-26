<?php

namespace App\Http\Controllers;

use App\Services\MercadoPagoService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;
    protected MercadoPagoService $mercadoPagoService;

    public function __construct(SubscriptionService $subscriptionService, MercadoPagoService $mercadoPagoService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->mercadoPagoService = $mercadoPagoService;
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

        $subscriptionUrl = $this->subscriptionService->subscribe($validatedData);

        return Inertia::location($subscriptionUrl);
    }

    public function paymentSuccess(Request $request)
    {
        return $this->mercadoPagoService->paymentSuccess($request);
    }

    public function paymentFailure(Request $request)
    {
        return $this->mercadoPagoService->paymentFailure($request);
    }

    public function paymentPending(Request $request)
    {
        return $this->mercadoPagoService->paymentPending($request);
    }

    public function webhook(Request $request)
    {
        return $this->mercadoPagoService->webhook($request);
    }
}
