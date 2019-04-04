<?php

namespace Ahmadabdallah\PayMob;

use GuzzleHttp\Client;

class PayMob
{
    protected $client;

    protected $integrationID;


    public function __construct()
    {
        $this->client = new Client();

        $this->integrationID = config('paymob.integration_id');
    }


    /**
     * @return mixed
     */
    public function getAuthenticationToken()
    {

        $response = $this->client->request('POST', config('paymob.authentication_token_endpoint'), [
            'json' => [
                "api_key" => config('paymob.api_key'),
            ]
        ]);

        return json_decode($response->getBody()->getContents());

    }


    /**
     * @param $token
     * @param $merchantId
     * @param $amountInCents
     * @param $merchantOrderId
     * @param string $currency
     * @return mixed
     */
    public function makeOrder($token, $merchantId, $amountInCents, $merchantOrderId, $currency = 'EGP')
    {

        $response = $this->client->request('POST', config('paymob.create_order_endpoint'), [
            'json' => [
                'auth_token' => $token,
                'delivery_needed' => 'false',
                'merchant_id' => $merchantId,      // merchant_id obtained from step 1
                'amount_cents' => $amountInCents,
                'currency' => $currency,
                'merchant_order_id' => $merchantOrderId,
                'notify_user_with_email' => true,
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $token
     * @param $amountCents
     * @param $orderId
     * @param $billingData
     * @param string $currency
     * @return mixed
     */
    public function createPaymentKeyToken(
        $token,
        $amountCents,
        $orderId,
        $billingData,
        $currency = 'EGP'
    )
    {
        $response = $this->client->request('POST', config('paymob.payment_key_token_endpoint'), [
            'json' => [
                "auth_token" => $token,
                "amount_cents" => $amountCents,
                "expiration" => 36000,
                "order_id" => $orderId,    // id obtained in step 2
                "currency" => $currency,
                "integration_id" => $this->integrationID, // card integration_id will be provided upon signing up,
                "lock_order_when_paid" => "true",
                "billing_data" => [
                    "apartment" => $billingData['apartment'],
                    "email" => $billingData['email'],
                    "floor" => $billingData['floor'],
                    "first_name" => $billingData['first_name'],
                    "street" => $billingData['street'],
                    "building" => $billingData['building'],
                    "phone_number" => $billingData['phone_number'],
                    "city" => $billingData['city'],
                    "country" => $billingData['country'],
                    "last_name" => $billingData['last_name'],
                ],
            ]
        ]);

        return json_decode($response->getBody()->getContents())->token;

    }


    /**
     * @param string
     * @param array|$source
     * @return mixed
     */
    public function createPayRequest($paymentKey, $source)
    {
        $response = $this->client->request('POST', config('paymob.pay_request_endpoint'), [
            'json' => [
                "source" => $source,
                "payment_token" => $paymentKey
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

}
