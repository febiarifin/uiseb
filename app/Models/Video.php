<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public const REVIEW = 1;
    public const REVISI_MINOR = 2;
    public const REVISI_MAYOR = 3;
    public const REJECTED = 4;
    public const ACCEPTED = 5;

    protected $fillable = [
        'link',
        'status',
        'acc_at',
        'paper_id',
    ];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function revisis()
    {
        return $this->hasMany(RevisiVideo::class);
    }
}
