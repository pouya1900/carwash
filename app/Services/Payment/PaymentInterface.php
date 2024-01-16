<?php


namespace App\Services\Payment;


interface PaymentInterface
{
    public function __construct();

    public function createPayment();

    public function verifyPayment();

}
