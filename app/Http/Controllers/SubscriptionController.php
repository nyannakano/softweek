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
            'thursday' => 'required',
            'tuesday' => 'required_without:tuesday1,tuesday2',
            'tuesday1' => 'required_without:tuesday',
            'tuesday2' => 'required_without:tuesday',
            'wednesday' => 'required_without:wednesday1,wednesday2',
            'wednesday1' => 'required_without:wednesday',
            'wednesday2' => 'required_without:wednesday',
            'friday' => 'required_without:friday1,friday2',
            'friday1' => 'required_without:friday',
            'friday2' => 'required_without:friday',
            'coupon' => 'nullable|exists:coupons,code',
            'transport' => 'nullable',
        ], [
            'friday.required' => 'O campo Sexta-feira é obrigatório.',
            'tuesday.required_without' => 'O campo Terça-feira é obrigatório.',
            'tuesday1.required_without' => 'O campo Terça-feira é obrigatório.',
            'tuesday2.required_without' => 'O campo Terça-feira é obrigatório.',
            'wednesday.required_without' => 'O campo Quarta-feira é obrigatório.',
            'wednesday1.required_without' => 'O campo Quarta-feira é obrigatório.',
            'wednesday2.required_without' => 'O campo Quarta-feira é obrigatório.',
            'thursday.required_without' => 'O campo Quinta-feira é obrigatório.',
            'coupon.exists' => 'Cupom inválido.',
            'friday1.required_without' => 'O campo Sexta-feira é obrigatório.',
            'friday2.required_without' => 'O campo Sexta-feira é obrigatório.',
        ]);

        $subscriptionUrl = $this->subscriptionService->subscribe($validatedData);

        return Inertia::location($subscriptionUrl);
    }

    public function paymentSuccess(Request $request)
    {
        $response = $this->mercadoPagoService->paymentSuccess($request);

        if ($response) {
            return redirect()->route('dashboard')->with('success', 'Inscrição realizada com sucesso!');
        }

        return redirect()->route('dashboard')->with('error', 'Erro ao realizar inscrição.');
    }

    public function paymentFailure(Request $request)
    {
        $this->mercadoPagoService->paymentFailure($request);

        return redirect()->route('dashboard')->with('error', 'Erro ao realizar inscrição. Verifique os dados de pagamento e tente novamente.');
    }

    public function paymentPending(Request $request)
    {
        $this->mercadoPagoService->paymentPending($request);

        return redirect()->route('dashboard')->with('success', 'Inscrição pendente de pagamento.');
    }

    public function webhook(Request $request)
    {
        return $this->mercadoPagoService->webhook($request);
    }

    public function getSubscriptionsAsAdmin()
    {
        return view('admin.subscription', [
            'subscriptions' => $this->subscriptionService->getSubscriptions(),
        ]);
    }

    public function confirmPayment($id)
    {
        $this->subscriptionService->confirmPayment($id);

        return redirect()->route('admin.subscriptions')->with('success', 'Pagamento confirmado com sucesso.');
    }
}
