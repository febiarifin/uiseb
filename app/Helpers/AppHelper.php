<?php

namespace App\Helpers;

class AppHelper{

    public static function currency($number)
    {
        $new_number = "Rp " . number_format($number, 0, ',', '.');
        return $new_number;
    }

    public static function convert_base64($base_path)
    {
        $path = base_path($base_path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $image = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $image;
    }

}
