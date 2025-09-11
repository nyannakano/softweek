<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Day;
use App\Models\Event;
use App\Models\Subscription;
use App\Models\SubscriptionEvent;
use LaravelIdea\Helper\App\Models\_IH_Subscription_C;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        try {
            $mercadoPagoService = new MercadoPagoService();

            $value = $this->setValue($data['type']);

            if ($data['coupon']) {
                $percentage = $this->checkCoupon($data['coupon']);
                $value = $value - ($value * $percentage);
                $coupon = Coupon::where('code', $data['coupon'])->first();
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
                    'type' => $data['type'] ?? null,
                    'payment_url' => $subscription->init_point ?? null,
                ]);

            $subscribe->events()->detach();

            $monday = Day::where('name', 'monday')->where('period', 'all_day')->first();
            $event_monday = Event::where('day_id', $monday->id)->first();

            $subscribe->events()->attach($event_monday->id);

            $happy_hour = $data['type'] ?? null;

            if ($happy_hour === 'workshops_happy_hour') {
                $day_friday = Day::where('name', 'friday')->where('period', 'all_day')->first();
                $event_friday = Event::where('day_id', $day_friday->id)->first();

                $subscribe->events()->attach($event_friday->id);
            }

//            if ($data['tuesday']) {
//                $subscribe->events()->attach($data['tuesday']);
//
//            } else {
//                $subscribe->events()->attach($data['tuesday1']);
//                $subscribe->events()->attach($data['tuesday2']);
//            }
//
//            if ($data['wednesday']) {
//                $subscribe->events()->attach($data['wednesday']);
//            } else {
//                $subscribe->events()->attach($data['wednesday1']);
//                $subscribe->events()->attach($data['wednesday2']);
//            }
//
//            if ($data['friday']) {
//                $subscribe->events()->attach($data['friday']);
//            } else {
//                $subscribe->events()->attach($data['friday1']);
//                $subscribe->events()->attach($data['friday2']);
//            }

            $subscribe->save();

            if ($status != 'failed') {
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

    public function getSubscriptions()
    {
        return Subscription::with('user', 'coupon', 'events')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function isSubscribed($user): bool
    {
        $subscription = Subscription::where('user_id', $user->id)->where('status', '!=', 'failed')->first();

        return (bool)$subscription;
    }

    public function getSubscription($user)
    {
        $subscription = Subscription::with('events.day')->where('user_id', $user->id)->first();
        $subscription->will_participate_happy_hour = false;

        $subscription->events->map(function ($event) use ($subscription) {
            if ($event->day->name == 'monday') {
                $subscription->will_participate_happy_hour = true;
            }
        });

        return $subscription;
    }

    public function setValue($willParticipateHappyHour): float
    {
        if ($willParticipateHappyHour == 'workshops_happy_hour') {
            return 1.0;
        } elseif ($willParticipateHappyHour == 'workshops') {
            return 1.0;
        }

        return 1.0;
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

    public function confirmPayment($id)
    {
        $subscription = Subscription::find($id);
        $subscription->status = 'paid';
        $subscription->save();

        return true;
    }

    public function getSubscriptionsByEventId($id)
    {
        $event = Event::find($id);

        $subscriptions = $event->subscriptions;

        $response = new StreamedResponse(function () use ($subscriptions) {

            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ['Nome', 'CPF', 'RA', 'E-mail', 'Status da inscrição']);

            // Add CSV rows
            foreach ($subscriptions as $subscription) {

                if ($subscription->status == 'failed') {
                    continue;
                }

                if ($subscription->status == 'pending') {
                    $subscription->status = 'Pendente';
                } else {
                    $subscription->status = 'Confirmado';
                }

                fputcsv($handle, [
                    $subscription->user->name,
                    $subscription->user->cpf,
                    $subscription->user->ra ?? '',
                    $subscription->user->email,
                    $subscription->status,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="inscritos_' . $event->title .'.csv"');

        return $response;
    }

    public function getTransportCount()
    {
        $subscriptions = Subscription::where('status', 'paid')
            ->where('transport', true)
            ->whereHas('events', function ($query) {
                $query->where('title', 'Happy Hour');
            })
            ->get();

        return $subscriptions->count();
    }

    public function subscribeApi($params)
    {
        $mercadoPagoService = new MercadoPagoService();
    }

    public function checkIfAlreadyHaveEvents($user)
    {
        $subscription = Subscription::where('user_id', $user->id)->where('status', '!=', 'failed')->first();

        if (!$subscription) {
            return false;
        }

       if ($subscription->type == 'only_opening') {
           return true;
       }

       $subCount = SubscriptionEvent::where('subscription_id', $subscription->id)->count();

       if ($subCount > 2) {
           return true;
       }

       return false;
    }

    public function subscribeEvents($data)
    {
        try {
            $user = auth()->user();

            $subscribe = Subscription::where('user_id', $user->id)->where('status', '!=', 'failed')->first();

            if (!$subscribe) {
                return false;
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

            return true;
        } catch (\Exception $e) {
            \Log::error('Error subscribing events: ' . $e);

            return false;
        }
    }
}
