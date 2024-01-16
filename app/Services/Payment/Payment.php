<?php


namespace App\Services\Payment;

class Payment
{

    public $payment;

    public function __construct(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function createPayment()
    {
        $this->payment->createPayment();
    }

    public function verifyPayment()
    {
        $this->payment->verifyPayment();
    }

}
