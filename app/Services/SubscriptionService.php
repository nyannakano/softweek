<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Day;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Subscription_C;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        try {
            $mercadoPagoService = new MercadoPagoService();

            $value = 75.0;

            if ($data['coupon']) {
                $coupon = Coupon::where('code', $data['coupon'])->first();

                if ($coupon) {
                    $value = $value - ($value * $coupon->percentage);
                }
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

            if ($data['friday'] === 'yes') {
                $day_friday = Day::where('name', 'friday')->first();
                $event_friday = Event::where('day_id', $day_friday->id)->first();
                $subscribe->events()->attach($event_friday->id);
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

            if ($data['thursday']) {
                $subscribe->events()->attach($data['thursday']);
            } else {
                $subscribe->events()->attach($data['thursday1']);
                $subscribe->events()->attach($data['thursday2']);
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
            \Log::error('Error subscribing: ' . $e->getMessage());
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
}
