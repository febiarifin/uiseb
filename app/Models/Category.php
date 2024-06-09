<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const IS_PAPER = 1;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'is_paper',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
