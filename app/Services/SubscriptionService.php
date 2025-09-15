<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Day;
use App\Models\Event;
use App\Models\Subscription;
use App\Models\SubscriptionEvent;
use LaravelIdea\Helper\App\Models\_IH_Subscription_C;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function Laravel\Prompts\error;

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
                'user_id' => auth()->id()
            ],
                [
                    'status' => $status,
                    'payment_id' => $subscription->id ?? 'without_payment',
                    'coupon_id' => $coupon->id ?? null,
                    'type' => $data['type'] ?? null,
                    'payment_url' => $subscription->init_point ?? null,
                    'external_reference' => $subscription->external_reference ?? null,
                ]);

            $subscribe->events()->detach();

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

    public function getSubscriptionCountForOnlyOpening()
    {
        return Subscription::where('type', 'only_opening')->count();
    }

    public function getSubscriptionCountForWorkshops()
    {
        return Subscription::where('type', 'workshops')->count();
    }

    public function getSubscriptionCountForWorkshopsHappyHour()
    {
        return Subscription::where('type', 'workshops_happy_hour')->count();
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

    /**
     * @throws \Exception
     */
    public function setValue($type): float
    {
        $countOnlyOpening = Subscription::where('type', 'only_opening')->where('status', 'paid')->where('payment_id', '!=', 'without_payment')->count();
        $countWorkshops = Subscription::whereIn('type', ['workshops', 'workshops_happy_hour'])->where('status', 'paid')->where('payment_id', '!=', 'without_payment')->count();

        if ($type === 'only_opening') {
            if ($countOnlyOpening < 50) {
                return 30.0;
            } else {
                throw new \Exception('Ingressos para abertura esgotados.');
            }
        }

        if (in_array($type, ['workshops', 'workshops_happy_hour'])) {
            if ($countWorkshops < 50) {
                return $type === 'workshops_happy_hour' ? 70.0 : 60.0;
            } elseif ($countWorkshops < 100) {
                return $type === 'workshops_happy_hour' ? 80.0 : 70.0;
            } elseif ($countWorkshops < 125) {
                return $type === 'workshops_happy_hour' ? 90.0 : 80.0;
            } else {
                throw new \Exception('Ingressos para workshops esgotados.');
            }
        }

        throw new \Exception('Inscrição inválida.');
    }

    public function checkCoupon($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return 0;
        }

        $uses = Subscription::where('coupon_id', $coupon->id)->count();

        if ($uses >= $coupon->max_uses) {
            return 0;
        }

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
        $response->headers->set('Content-Disposition', 'attachment; filename="inscritos_' . $event->title . '.csv"');

        return $response;
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

    public function checkIfSubscriptionIsPaid($user)
    {
        $subscription = Subscription::where('user_id', $user->id)->where('status', '!=', 'failed')->first();

        if (!$subscription) {
            return false;
        }

        if ($subscription->status == 'paid') {
            return true;
        }

        try {
            $mercadoPagoService = new MercadoPagoService();
            $mercadoPagoService->checkIfIsPaid($subscription);
        } catch (MPApiException $e) {
            \Log::error('Error checking subscription: ' . $e->getMessage());
            \Log::error('Error api: ', $e->getApiResponse()->getContent());

        }   catch (\Throwable $e) {
            \Log::error('Error checking subscription: ' . $e->getMessage());
            return false;
        }

        return true;
    }
}
