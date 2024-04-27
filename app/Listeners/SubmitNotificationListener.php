<?php

namespace App\Listeners;

use App\Services\sms\Kavenegar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SubmitNotificationListener
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
        $event->notifiable_model->notifications()->create([
            "title" => $event->message,
            "seen"  => 0,
        ]);

        if ($event->sms) {
            $kavenegar = new Kavenegar();

            $kavenegar->send($event->notifiable_model->mobile, $event->message);
        }
    }
}
