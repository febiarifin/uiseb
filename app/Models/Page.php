<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public const ENABLE = 1;
    public const DISABLE = 0;

    protected $fillable = [
        'name',
        'theme',
        'date',
        'about_1',
        'about_2',
        'image_1',
        'image_2',
        'image_3',
        'scope',
        'submission',
        'status',
    ];

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
