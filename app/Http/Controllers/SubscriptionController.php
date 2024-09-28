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
            'tuesday' => 'required_without:tuesday1,tuesday2',
            'tuesday1' => 'required_without:tuesday',
            'tuesday2' => 'required_without:tuesday',
            'wednesday' => 'required_without:wednesday1,wednesday2',
            'wednesday1' => 'required_without:wednesday',
            'wednesday2' => 'required_without:wednesday',
            'thursday' => 'required_without:thursday1,thursday2',
            'thursday1' => 'required_without:thursday',
            'thursday2' => 'required_without:thursday',
            'lunch' => 'required_if:friday,yes',
            'drink' => 'required_if:friday,yes',
            'coupon' => 'nullable|exists:coupons,code',
        ], [
            'lunch.required_if' => 'O lanche é obrigatório caso vá participar do Happy Hour.',
            'drink.required_if' => 'A bebida é obrigatória caso vá participar do Happy Hour.',
            'friday.required' => 'O campo Sexta-feira é obrigatório.',
            'tuesday.required_without' => 'O campo Terça-feira é obrigatório.',
            'tuesday1.required_without' => 'O campo Terça-feira é obrigatório.',
            'tuesday2.required_without' => 'O campo Terça-feira é obrigatório.',
            'wednesday.required_without' => 'O campo Quarta-feira é obrigatório.',
            'wednesday1.required_without' => 'O campo Quarta-feira é obrigatório.',
            'wednesday2.required_without' => 'O campo Quarta-feira é obrigatório.',
            'thursday.required_without' => 'O campo Quinta-feira é obrigatório.',
            'thursday1.required_without' => 'O campo Quinta-feira é obrigatório.',
            'thursday2.required_without' => 'O campo Quinta-feira é obrigatório.',
            'coupon.exists' => 'Cupom inválido.',
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
