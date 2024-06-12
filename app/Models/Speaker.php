<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    public const IS_KEYNOTE = 1;
    public const IS_INVITED = 0;

    protected $fillable = [
        'image',
        'name',
        'institution',
        'is_keynote',
        'page_id',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
