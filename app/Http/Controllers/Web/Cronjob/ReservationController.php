<?php

namespace App\Http\Controllers\Web\Cronjob;

use App\Events\SendPushNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class ReservationController extends Controller
{

    public function send_notification_before_one_hour()
    {
        $reservations = Reservation::wherehas("time", function ($q) {
            return $q->wherebetween("start", [Carbon::now(), Carbon::now()->addHour()]);
        })->where("status", "approved")->where("notif", 0)->get();

        foreach ($reservations as $reservation) {
            $minute = 60 - Carbon::now()->minute;
            $carwash = $reservation->carwash->title;
            $title = "$minute دقیقه مانده تا نوبت کارواش";
            $message = "لطفا تا $minute دقیقه دیگر در کارواش $carwash حضور داشته باشید. ";
            Event::dispatch(new SendPushNotificationEvent($reservation->user->firebase_token, $title, $message));
        }

    }

}
