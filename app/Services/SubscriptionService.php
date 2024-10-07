<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Day;
use App\Models\Event;
use App\Models\Subscription;
use LaravelIdea\Helper\App\Models\_IH_Subscription_C;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        try {
            $mercadoPagoService = new MercadoPagoService();

            $value = $this->setValue($data['thursday']);

            if ($data['coupon']) {
                $percentage = $this->checkCoupon($data['coupon']);
                $value = $value - ($value * $percentage / 100);
            }

            $status = 'paid';

            if ($value > 0) {
                $subscription = $mercadoPagoService->setProduct($value);
                $status = 'pending';
            }

            $subscribe = Subscription::updateOrCreate([
                'user_id' => auth()->id()],
                [
                    'status' => $status,
                    'payment_id' => $subscription->external_reference ?? 'without_payment',
                    'coupon_id' => $coupon->id ?? null,
                ]);

            $subscribe->events()->detach();

            $monday = Day::where('name', 'monday')->first();
            $event_monday = Event::where('day_id', $monday->id)->first();

            $subscribe->events()->attach($event_monday->id);

            if ($data['thursday'] === 'yes') {
                $day_thursday = Day::where('name', 'thursday')->first();
                $event_thursday = Event::where('day_id', $day_thursday->id)->first();
                $subscribe->events()->attach($event_thursday->id);
            }

            if ($data['tuesday']) {
                $subscribe->events()->attach($data['tuesday']);

            } else {
                $subscribe->events()->attach($data['tuesday1']);
                $subscribe->events()->attach($data['tuesday2']);
            }

            if ($data['wednesday']) {
                $subscribe->events()->attach($data['wednesday']);
            } else {
                $subscribe->events()->attach($data['wednesday1']);
                $subscribe->events()->attach($data['wednesday2']);
            }

            if ($data['friday']) {
                $subscribe->events()->attach($data['friday']);
            } else {
                $subscribe->events()->attach($data['friday1']);
                $subscribe->events()->attach($data['friday2']);
            }

            $subscribe->save();

            if ($status == 'paid') {
                $events = $subscribe->events;

                foreach ($events as $event) {
                    $event->slots -= 1;
                    $event->save();
                }
            }

            return $subscription->init_point ?? '/dashboard';
        } catch (\Exception $e) {
            \Log::error('Error subscribing: ' . $e);
            return null;
        }
    }

    public function getSubscriptions(): \Illuminate\Database\Eloquent\Collection|_IH_Subscription_C|array
    {
        return Subscription::with('user', 'coupon', 'events')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function isSubscribed($user): bool
    {
        $subscription = Subscription::where('user_id', $user->id)->where('status', 'paid')->first();

        return (bool)$subscription;
    }

    public function getSubscription($user)
    {
        return Subscription::with('events.day', 'lunch')->where('user_id', $user->id)->first();
    }

    public function setValue($willParticipateHappyHour): float
    {
        if ($willParticipateHappyHour == 'yes') {
            return 70.0;
        }

        return 60.0;
    }

    public function checkCoupon($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return 0;
        }

        if ($coupon->uses >= $coupon->max_uses) {
            return 0;
        }

        $coupon->uses += 1;
        $coupon->save();

        return $coupon->percentage;
    }
}
