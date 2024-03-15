<?php

namespace App\Listeners;

use App\Services\sms\Kavenegar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $mobile = $event->mobile;
        $code = $event->code;

        $kavenegar = new Kavenegar();

        $kavenegar->otp($mobile, $code);

    }
}
