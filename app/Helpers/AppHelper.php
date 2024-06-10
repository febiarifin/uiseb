<?php

namespace App\Helpers;

use Carbon\Carbon;

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

    public static function parse_date($date)
    {
        $parse_date = Carbon::parse($date);
        $new_date = $parse_date->isoFormat('dddd, D MMMM YYYY H:mm A');
        return $new_date;
    }

    public static function parse_date_short($date)
    {
        $parse_date = Carbon::parse($date);
        $new_date = $parse_date->format('d/m/Y H:i A');
        return $new_date;
    }

    public static function upload_file($file, $path)
    {
        if ($file){
            $file_path = $file->store($path, 'public');
            return 'storage/'.$file_path;
        }
    }

    public static function delete_file($file)
    {
        if ($file){
            if (file_exists(public_path($file))){
                unlink(public_path($file));
            }
        }
    }

}
