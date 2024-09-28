<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Subscription;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        try {
            $mercadoPagoService = new MercadoPagoService();

            $value = 20.0;

            if ($data['coupon']) {
                $coupon = Coupon::where('code', $data['coupon'])->first();

                if ($coupon) {
                    $value = $value - ($value * $coupon->percentage);
                }
            }

            $subscription = $mercadoPagoService->setProduct($value);

            $subscribe = Subscription::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_id' => $subscription->external_reference
            ]);

            return $subscription->init_point;
        } catch (\Exception $e) {
            \Log::error('Error subscribing: ' . $e->getMessage());
            return null;
        }
    }
}
