<?php

namespace App;


use App\Models\Car;
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

        for ($i = 0; $i < 8; $i++) {
            $day = Carbon::now()->addDays($i)->startOfDay();

            $day_week = $day->weekday();
            $h = "day" . $day_week;

            $free_times[$i]['date'] = jdate(strtotime($day))->format("Y-m-d");
            $free_times[$i]['times']=[];
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
                                    "start"    => $j,
                                    "end"      => $j + 1,
                                    "number"   => $number - $used_times->count(),
                                    "total"    => $number,
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

    public static function getFirstFreeTime($carwash, $date, $time)
    {
        $schedule = $carwash->schedule;

        $day = $date->startOfDay();

        $day_week = $day->weekday();

        if ($schedule) {

            for ($i = 0; $i < 7; $i++) {
                $h = "day" . ($day_week + $i == 7 ? 0 : $day_week + $i);
                $schedule_day = $schedule->$h;
                $schedule_day = json_decode($schedule_day, true);
                if ($schedule_day) {
                    $number = $schedule_day["number"];
                    foreach ($schedule_day["times"] as $item) {
                        $for_start = $i == 0 ? $time : $item[0];
                        for ($j = $for_start; $j < $item[1]; $j++) {
                            $start = $day->copy()->startOfDay()->addDays($i)->addHours($j);
                            $used_times = $carwash->times()->whereNotNull("reservation_id")->where("start", $start)->get();
                            $off = $carwash->times()->whereNull("reservation_id")->where("start", "<=", $start)->where("end", ">", $start)->first();

                            if (!$off && $used_times->count() < $number && Carbon::now() < $start->copy()->addMinutes(30)) {
                                return $start;
                            }
                        }
                    }
                }
            }
        }
        return null;
    }

    public static function isFree($carwash, $date, $time)
    {
        $schedule = $carwash->schedule;

        $day = $date->startOfDay();

        $date_time = $date->startOfDay()->addHours($time);

        $day_week = $day->weekday();
        $h = "day" . $day_week;

        if ($schedule) {
            $schedule_day = $schedule->$h;

            $schedule_day = json_decode($schedule_day, true);
            if ($schedule_day) {
                $number = $schedule_day["number"];

                $used_times = $carwash->times()->whereNotNull("reservation_id")->where("start", $date_time)->get();
                $off = $carwash->times()->whereNull("reservation_id")->where("start", "<=", $date_time)->where("end", ">", $date_time)->first();

                if ($used_times->count() >= $number) {
                    return [
                        "number"  => $number - $used_times->count(),
                        "total"   => $number,
                        "is_free" => 0,
                    ];
                }

                if ($off) {
                    return [
                        "is_free" => 0,
                    ];
                }
                foreach ($schedule_day["times"] as $item) {
                    $start = $day->copy()->startOfDay()->addHours($item[0]);
                    $end = $day->copy()->startOfDay()->addHours($item[1]);

                    if ($start <= $date_time && $date_time < $end) {
                        return [
                            "number"  => $number - $used_times->count(),
                            "total"   => $number,
                            "is_free" => 1,
                        ];
                    }
                }
            }
        }
        return [
            "is_free" => 0,
        ];
    }

    public static function hasDiscount($carwash, $date, $time)
    {
        $date_time = $date->startOfDay()->addHours($time);

        return $carwash->discounts()->where("start", "<=", $date_time)->where("end", ">", $date_time)->first();

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
