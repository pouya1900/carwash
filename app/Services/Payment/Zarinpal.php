<?php


namespace App\Services\Payment;

class Zarinpal implements PaymentInterface
{

    public function __construct()
    {
    }

    public function createPayment($amount, $callback_url)
    {
        $amount = 2000;
        $ch = curl_init();
        $service_url = "https://api.zarinpal.com/pg/v4/payment/request.json";
        $post_data = [
            "merchant_id"  => env("ZARINPAL_MERCHANT"),
            "amount"       => $amount * 10,
            "callback_url" => $callback_url,
            "description"  => "test",
            "metadata"     => ["email" => "info.test@gmail.com",],
        ];
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        if ($response && isset($response["data"]) && isset($response["data"]["code"]) && $response["data"]["code"] == 100) {
            $link = "https://www.zarinpal.com/pg/StartPay/" . $response["data"]["authority"];
            return ["status" => 0, "link" => $link];
        } else {
            return ["status" => 1];
        }

    }

    public function verifyPayment($status, $authority, $amount)
    {
        $amount = 2000;
        if (!$status || $status != "OK") {
            return ["status" => 2];
        }

        $ch = curl_init();
        $service_url = "https://api.zarinpal.com/pg/v4/payment/verify.json";
        $post_data = [
            "merchant_id" => env("ZARINPAL_MERCHANT"),
            "amount"      => $amount * 10,
            "authority"   => $authority,
        ];
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        if ($response && isset($response["data"]) && isset($response["data"]["code"]) && $response["data"]["code"] == 100) {
            return ["status" => 0, "ref_id" => $response["data"]["ref_id"]];
        } elseif ($response && isset($response["data"]) && isset($response["data"]["code"]) && $response["data"]["code"] == 101) {
            return ["status" => 1, "ref_id" => $response["data"]["ref_id"]];
        }

        return ["status" => 2];

    }

}
