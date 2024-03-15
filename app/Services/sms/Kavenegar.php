<?php

namespace App\Services\sms;

class Kavenegar
{

    private $base_address;

    public function __construct()
    {
        $api_key = env("KAVENEGAR_API_KEY");
        $this->base_address = "https://api.kavenegar.com/v1/$api_key";
    }

    public function otp($mobile, $token)
    {
        $service_url = $this->base_address . "/verify/lookup.json" . "?receptor=$mobile&token=$token&template=send";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        if ($response && isset($response["return"])
            && isset($response["return"]["status"])
            && $response["return"]["status"] == 200
            && isset($response["entries"])
            && isset($response["entries"][0])
            && isset($response["entries"][0]["status"])
            && ($response["entries"][0]["status"] <= 5 || $response["entries"][0]["status"] == 10)) {
            return 1;
        }

        return 0;
    }

    public function send($mobile, $message)
    {
        $service_url = $this->base_address . "/sms/send.json" . "?receptor=$mobile&message=$message";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        if ($response && isset($response["return"])
            && isset($response["return"]["status"])
            && $response["return"]["status"] == 200
            && isset($response["entries"])
            && isset($response["entries"][0])
            && isset($response["entries"][0]["status"])
            && ($response["entries"][0]["status"] <= 5 || $response["entries"][0]["status"] == 10)) {
            return 1;
        }

        return 0;
    }

}
