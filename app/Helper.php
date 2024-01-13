<?php

namespace App;


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


}
