<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const IS_PAPER = 1;
    public const IS_ACTIVE = 1;
    public const IS_DISABLE = 0;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'is_paper',
        'page_id',
        'is_active',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
