<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public const IS_VALID = 1;

    public const REVIEW = 1;
    public const REVISI = 2;
    public const ACC = 3;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'institution',
        'position',
        'subject_background',
        'is_valid',
        'status',
        'payment_image',
        'paper',
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
}
