<?php


namespace App\Services\Payment;


interface PaymentInterface
{
    public function __construct();

    public function createPayment($amount,$callback_url);

    public function verifyPayment($status, $authority, $payment);

}
