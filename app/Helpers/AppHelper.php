<?php

namespace App\Helpers;

use App\Models\Abstrak;
use App\Models\Paper;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AppHelper{

    public static function currency($category)
    {
        // $new_number = "Rp " . number_format($number, 0, ',', '.');
        $currency = $category->is_dollar ? 'USD ' : 'IDR ';
        $amount = $currency . number_format($category->amount, 0, ',', '.');
        $amount_max = $currency . number_format($category->amount_max, 0, ',', '.');
        return $category->amount_max != 0 ? $amount.' - '.$amount_max : $amount;
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

    public static function parse_date_timeline($date)
    {
        $parse_date = Carbon::parse($date);
        $new_date = $parse_date->isoFormat('D MMMM, YYYY');
        return $new_date;
    }

    public static function upload_file($file, $path)
    {
        if ($file){
            $file_path = $file->store($path, 'public');
            return 'storage/'.$file_path;
        }
    }

    public static function create_abstrak($registration)
    {
        if ($registration->category->is_paper) {
            Abstrak::create([
                'registration_id' => $registration->id,
            ]);
        }
    }

    public static function create_paper($abstrak)
    {
        Paper::create([
            'abstrak_id' => $abstrak->id,
        ]);
    }

    public static function create_video($paper)
    {
        Video::create([
            'paper_id' => $paper->id,
        ]);
    }

    public static function delete_file($file)
    {
        if ($file){
            if (file_exists(public_path($file))){
                unlink(public_path($file));
            }
        }
    }

    public static function file_short_name($file)
    {
        return Str::substr($file, 40);
    }

}
