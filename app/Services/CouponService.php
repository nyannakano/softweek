<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function getCoupons()
    {
        return Coupon::all();
    }

    public function createCoupon(array $data)
    {
        try {
            return Coupon::create([
                'code' => $data['code'],
                'percentage' => $data['percentage'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating coupon', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
