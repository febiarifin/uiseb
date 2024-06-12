<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'page_id',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
