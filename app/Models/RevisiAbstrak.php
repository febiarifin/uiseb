<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisiAbstrak extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'file',
        'file_abstrak',
        'abstrak_id',
        'user_id',
    ];

    public function abstrak()
    {
        return $this->belongsTo(Abstrak::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
