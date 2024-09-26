<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        $mercadoPagoService = new MercadoPagoService();

        $value = 20.0;

        $subscription = $mercadoPagoService->setProduct($value);

        $subscribe = Subscription::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'payment_id' => $subscription->external_reference
        ]);

        return $subscription->init_point;
    }
}
