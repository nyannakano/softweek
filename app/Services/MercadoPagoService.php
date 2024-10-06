<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Subscription;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    protected PreferenceClient $client;

    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        $this->client = new PreferenceClient();
    }

    public function setProduct($value)
    {
        $random_id = rand(1, 10000);

        while (Subscription::where('payment_id', $random_id)->exists()) {
            $random_id = rand(1, 10000);
        }

        return $this->client->create([
            "items" => array(
                array(
                    "title" => "Softweek Inscrição",
                    "quantity" => 1,
                    "unit_price" => $value
                )
            ),
            "back_urls" => [
                "success" =>  config('services.url') . "/payment-success",
                "failure" => config('services.url') . "/payment-failure",
                "pending" =>  config('services.url') . "/payment-pending"
            ],
            "external_reference" => $random_id,
            "notification_url" => config('services.url') . "/webhook",
        ]);
    }

    public function paymentSuccess($request): string
    {
        $subscription = Subscription::where('payment_id', $request->external_reference)->first();
        $subscription->status = 'paid';
        $subscription->save();
        $subscriptionId = $subscription->id;

        $events = Event::whereHas('subscriptions', function ($query) use ($subscriptionId) {
            $query->where('subscription_id', $subscriptionId);
        })->get();

        foreach ($events as $event) {
            $event->slots = $event->slots - 1;
            $event->save();
        }

        return 'Pagamento realizado com sucesso!';
    }

    public function paymentFailure($request)
    {
        $subscription = Subscription::where('payment_id', $request->external_reference)->first();
        $subscription->status = 'failed';
        $subscription->save();

        return 'Falha no pagamento!';
    }

    public function paymentPending($request)
    {
        $subscription = Subscription::where('payment_id', $request->external_reference)->first();
        $subscription->status = 'pending';
        $subscription->save();

        return 'Pagamento pendente!';
    }

    public function webhook($request)
    {
        $subscription = Subscription::where('payment_id', $request->external_reference)->first();

        if ($request->status == 'paid') {
            $subscription->status = $request->status;
            $subscription->save();

            $subscriptionId = $subscription->id;

            $events = Event::whereHas('subscriptions', function ($query) use ($subscriptionId) {
                $query->where('subscription_id', $subscriptionId);
            })->get();

            foreach ($events as $event) {
                $event->slots = $event->slots - 1;
                $event->save();
            }

            return 'Webhook recebido!';
        }

        $subscription->status = $request->status;
        $subscription->save();

        return 'Webhook recebido!';
    }

}
