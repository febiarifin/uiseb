<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public const IS_VALID = 1;
    public const NOT_VALID = 2;

    public const REVIEW = 1;
    public const REVISI = 2;
    public const ACC = 3;

    protected $fillable = [
        'is_valid',
        'status',
        'payment_image',
        'paper',
        'validated_at',
        'acc_at',
        'note',
        'category_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function abstraks()
    {
        return $this->hasMany(Abstrak::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($registration) {
            $registration->revisions()->delete();
            $registration->abstraks()->delete();
        });
    }
}
