<?php

namespace App\Services;

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

        $preference = $this->client->create([
            "items" => array(
                array(
                    "title" => "Softweek Inscrição",
                    "quantity" => 1,
                    "unit_price" => $value
                )
            ),
            "back_urls" => [
                "success" => "http://localhost:8000/success",
                "failure" => "http://localhost:8000/failure",
                "pending" => "http://localhost:8000/pending"
            ],
            "external_reference" => $random_id,
            "notification_url" => "http://localhost:8000/webhook"
        ]);

        return $preference;
    }

    public function paymentSuccess($request)
    {
        $subscription = Subscription::where('payment_id', $request->external_reference)->first();
        $subscription->status = 'paid';
        $subscription->save();

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
        $subscription->status = $request->status;
        $subscription->save();

        return 'Webhook recebido!';
    }

}


