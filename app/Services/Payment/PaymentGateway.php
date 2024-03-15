<?php


namespace App\Services\Payment;

class PaymentGateway
{

    public $gateway;

    public function __construct(PaymentInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function createPayment($amount, $callback_url)
    {
        return $this->gateway->createPayment($amount, $callback_url);
    }

    public function verifyPayment($status, $authority, $payment)
    {
        return $this->gateway->verifyPayment($status, $authority, $payment);
    }

}
