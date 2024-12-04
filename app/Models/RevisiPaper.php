<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisiPaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'file',
        'file_paper',
        'is_accepted_turnitin',
        'paper_id',
        'user_id',
    ];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
