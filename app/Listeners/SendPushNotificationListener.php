<?php

namespace App\Listeners;

use App\Services\notification\FireBase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPushNotificationListener
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
        $to = $event->to;
        $title = $event->title;
        $message = $event->message;

        $fire_base = new FireBase();

        $fire_base->sendNotification($to, $title, $message);

    }
}
