<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Day;
use App\Models\Event;
use App\Models\Subscription;
use LaravelIdea\Helper\App\Models\_IH_Subscription_C;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriptionService
{
    public function subscribe($data): ?string
    {
        try {
            $mercadoPagoService = new MercadoPagoService();

            $value = $this->setValue($data['thursday']);

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
                ]);

            $subscribe->events()->detach();

            $monday = Day::where('name', 'monday')->first();
            $event_monday = Event::where('day_id', $monday->id)->first();

            $subscribe->events()->attach($event_monday->id);

            $happy_hour = $data['thursday'] ?? null;
            $subscribe->transport = false;

            if ($happy_hour === 'yes_transport' || $happy_hour === 'yes_without_transport') {
                $day_thursday = Day::where('name', 'thursday')->first();
                $event_thursday = Event::where('day_id', $day_thursday->id)->first();

                if ($happy_hour === 'yes_transport') {
                    $subscribe->transport = true;
                }

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
        $subscription = Subscription::with('events.day', 'lunch')->where('user_id', $user->id)->first();
        $subscription->will_participate_happy_hour = false;

        $subscription->events->map(function ($event) use ($subscription) {
            if ($event->day->name == 'thursday') {
                $subscription->will_participate_happy_hour = true;
            }
        });

        return $subscription;
    }

    public function setValue($willParticipateHappyHour): float
    {
        if ($willParticipateHappyHour == 'yes_transport' || $willParticipateHappyHour == 'yes_without_transport') {
            return 90.0;
        }

        return 80.0;
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

        $events = $subscription->events;

        foreach ($events as $e) {
            $e->slots -= 1;
            $e->save();
        }

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
}
