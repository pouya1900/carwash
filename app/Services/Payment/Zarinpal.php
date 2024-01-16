<?php


namespace App\Services\Payment;

class Zarinpal implements PaymentInterface
{

    public function __construct()
    {
    }

    public function createPayment()
    {

        $callback_url = "https://moon-dress1.ir/api/v1/user/payment/verify";
        $ch = curl_init();
        $service_url = "https://sandbox.zarinpal.com/pg/v4/payment/request.json";
        $post_data = [
            "merchant_id"  => "96589658-1254-3256-7458-123456789123",
            "amount"       => "1100",
            "callback_url" => $callback_url,
            "description"  => "Transaction description.",
            "metadata"     => ["mobile" => "09106869409", "email" => "info.test@gmail.com",],
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
        dd($result);
        return $response;
    }

    public function verifyPayment()
    {

    }

}
