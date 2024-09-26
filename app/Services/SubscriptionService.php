<?php

namespace App\Services;

class SubscriptionService
{
    public function subscribe($data)
    {
        $mercadoPagoService = new MercadoPagoService();

        $value = 20.0;

        return $mercadoPagoService->setProduct($value);
    }
}
