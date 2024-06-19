<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abstrak extends Model
{
    use HasFactory;

    public const REVIEW = 1;
    public const REVISI_MINOR = 2;
    public const REVISI_MAYOR = 3;
    public const REJECTED = 4;
    public const ACCEPTED = 5;

    protected $fillable = [
        'title',
        'file',
        'status',
        'acc_at',
        'registration_id',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function penulis()
    {
        return $this->hasMany(Penulis::class);
    }

    public function paper()
    {
        return $this->hasOne(Paper::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'abstrak_users', 'abstrak_id', 'user_id')->withPivot(['id']);;
    }

    public function revisis()
    {
        return $this->hasMany(RevisiAbstrak::class);
    }
}
