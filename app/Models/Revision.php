<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'attachment',
        'registration_id',
        'user_id',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
