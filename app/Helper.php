<?php

namespace App;


use App\Models\Discount;
use Carbon\Carbon;

class Helper
{
    public static function getImageModel($path, $image_title, $is_default = 0): array
    {
        $image_model = [];

        foreach (config("image.size") as $key => $value) {
            $postfix = !$is_default ? $value["postfix"] : "";
            $image_model[$key] = $path . "/" . $postfix . $image_title;
        }

        return $image_model;
    }

    public static function getFreeTimes($carwash)
    {
        $schedule = $carwash->schedule;
        $times_table = $carwash->times()->orderBy('start', 'asc')->get();

        $free_times = [];

        for ($i = 0; $i < 15; $i++) {
            $day = Carbon::now()->addDays($i)->startOfDay();

            $day_week = $day->weekday();
            $h = "day" . $day_week;

            $free_times[$i]['date'] = $day->format('Y-m-d');

            if ($schedule) {
                $schedule_day = $schedule->$h;

                $schedule_day = json_decode($schedule_day, true);
                if ($schedule_day) {
                    $number = $schedule_day["number"];
                    foreach ($schedule_day["times"] as $item) {
                        for ($j = $item[0]; $j < $item[1]; $j++) {
                            $start = Carbon::now()->addDays($i)->startOfDay()->addHours($j);
                            $used_times = $carwash->times()->whereNotNull("reservation_id")->where("start", $start)->get();
                            $off = $carwash->times()->whereNull("reservation_id")->where("start", "<=", $start)->where("end", ">", $start)->first();

                            if (!$off && $used_times->count() < $number && $start > Carbon::now()) {
                                $discount = $carwash->discounts()->where("start", "<=", $start)->where("end", ">", $start)->first();
                                $free_times[$i]['times'][] = [
                                    "time"     => [$j, $j + 1],
                                    "number"   => $number - $used_times->count(),
                                    "discount" => $discount ? $discount->value : 0,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $free_times;

    }

    public static function getDistance($lat1, $long1, $lat2, $long2)
    {
        $rad = M_PI / 180;
        $radius = 6371; //earth radius in kilometers
        $distance = acos(sin($lat2 * $rad) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($long2 * $rad - $long1 * $rad)) * $radius; //result in Kilometers

        $distance = round($distance, 1);

        $distance = $distance * 1000;

        return $distance;


    }

}
