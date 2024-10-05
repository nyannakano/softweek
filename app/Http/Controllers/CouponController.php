<?php

namespace App\Http\Controllers;

use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function getCouponsAsAdmin()
    {
        $coupons = $this->couponService->getCoupons();

        return view('admin.coupon', compact('coupons'));
    }

    public function registerCoupon()
    {
        return view('admin.register-coupon');
    }

    public function createCoupon(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons',
            'percentage' => 'required',
            'max_uses' => 'required',
        ]);

        $coupon = $this->couponService->createCoupon($data);

        return redirect()->back()->with('success', 'Cupom cadastrado com sucesso.');
    }
}
