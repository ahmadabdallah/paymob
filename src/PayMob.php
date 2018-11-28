<?php

namespace Ahmadabdallah\PayMob;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PayMob
{
    public function __construct()
    {
        $this->client = new Client();
    }


    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    protected function getAuthenticationToken()
    {
        try {
            $response = $this->client->request('POST', 'https://accept.paymobsolutions.com/api/auth/tokens', [
                'json' => [
                    "api_key" => config('services.paymob.api_key'),
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());

        } catch (ClientException $exception) {
            throw  new \Exception($exception->getMessage());
        }

        return $response;

    }


    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    protected function createOrder()
    {
        try {
            $response = $this->client->request('POST', 'https://accept.paymobsolutions.com/api/ecommerce/orders', [
                'json' => [
                    "auth_token" => $this->authToken->token,
                    "delivery_needed" => "false",
                    "merchant_id" => $this->authToken->profile->id,      // merchant_id obtained from step 1
                    "amount_cents" => $this->data['amount'],
                    "currency" => "EGP",
                    "merchant_order_id" => $this->data['merchant_order_id'],
                    "items" => [],
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());

        } catch (ClientException $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $response;
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    protected function createPaymentKeyToken()
    {
        try {
            $response = $this->client->request('POST', 'https://accept.paymobsolutions.com/api/acceptance/payment_keys', [
                'json' => [
                    "auth_token" => $this->authToken->token,
                    "amount_cents" => $this->data['amount'],
                    "expiration" => 36000,
                    "order_id" => $this->order->id,    // id obtained in step 2
                    "currency" => "EGP",
                    "integration_id" => $this->integrationID, // card integration_id will be provided upon signing up,
                    "lock_order_when_paid" => "true",
                    "billing_data" => [
                        "apartment" => $this->data['apartment'],
                        "email" => $this->data['email'],
                        "floor" => $this->data['floor'],
                        "first_name" => $this->data['first_name'],
                        "street" => $this->data['street'],
                        "building" => $this->data['building'],
                        "phone_number" => $this->data['phone_number'],
                        "city" => $this->data['city'],
                        "country" => $this->data['country'],
                        "last_name" => $this->data['last_name'],
                    ],
                ]
            ]);

            $token = json_decode($response->getBody()->getContents())->token;

        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return $token;

    }


    /**
     * @param $data
     * @param $source
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function createPayRequest($data, $source)
    {
        try {
            $response = $this->client->request('POST', 'https://accept.paymobsolutions.com/api/acceptance/payments/pay', [
                'json' => [
                    "source" => $source,
                    "payment_token" => $data['payment_key']
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());

        } catch (ClientException $exception) {
            throw  new \Exception($exception->getResponse()->getBody());
        }

        return $response;
    }

}
