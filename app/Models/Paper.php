<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    public const REVIEW = 1;
    public const REVISI_MINOR = 2;
    public const REVISI_MAYOR = 3;
    public const REJECTED = 4;
    public const ACCEPTED = 5;

    protected $fillable = [
        'abstract',
        'keyword',
        'bibliography',
        'file',
        'status',
        'acc_at',
        'abstrak_id'
    ];

    public function abstrak()
    {
        return $this->belongsTo(Abstrak::class);
    }
}
