<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'affiliate',
        'coresponding',
        'abstrak_id',
    ];

    public function abstrak()
    {
        return $this->belongsTo(Abstrak::class);
    }
}
