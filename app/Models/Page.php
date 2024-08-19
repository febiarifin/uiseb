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
        'about_3',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'scope',
        'submission',
        'author_instruction',
        'template_word',
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

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }
}
