<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'page_id',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
