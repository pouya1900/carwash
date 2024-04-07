<?php

namespace App\Services\notification;

class FireBase
{

    private $token;

    public function __construct()
    {
        $this->token = env("FIREBASE_TOKEN");
    }

    public function sendNotification($to, $title, $message)
    {
        $service_url = "https://fcm.googleapis.com/fcm/send";

        $id = rand(1, 10000);

        $post_data = [
            "to"           => $to,
            "notification" => [
                "OrganizationId"    => "2",
                "content_available" => true,
                "priority"          => "high",
                "subtitle"          => "Elementary School",
            ],

            "data" => [
                "id"        => $id,
                "type"      => "alarm",
                "title"     => $title,
                "body"      => $message,
                "service"   => "",
                "datetime"  => "2024-04-05 11:00:00",
                "createdAt" => "2024-04-03 16:00:00",
            ],
        ];
        $ch = curl_init();
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
            "Authorization: key=$this->token",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        dd($result);
    }

}
