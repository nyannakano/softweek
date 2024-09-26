<?php

namespace App\Services;

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
            ]
        ]);

        return $preference->init_point;
    }

    public function paymentSuccess($request)
    {
        return 'Pagamento realizado com sucesso!';
    }

    public function paymentFailure($request)
    {
        return 'Falha no pagamento!';
    }

    public function paymentPending($request)
    {
        return 'Pagamento pendente!';
    }

}


