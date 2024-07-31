<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    public const REVIEW = 1;
    public const REVISI_MINOR = 2;
    public const REVISI_MAYOR = 3;
    public const REJECTED = 4;
    public const ACCEPTED = 5;
    public const REVIEW_EDITOR = 6;
    public const IS_PUBLISHED = 1;
    public const PUBLISHED_REVIEW = 1;

    public const COMMENTS = [
        'Is the manuscript important for scientific community?',
        'Is the title of the article suitable?',
        'Is the abstract of the article comprehensive?',
        'Are subsections and structure of the manuscript appropriate?',
        'Do you think the manuscript is scientifically correct?',
        'Are the references sufficient and recent? If you have suggestion of additional references, please mention in the review form',
    ];

    protected $fillable = [
        'abstract',
        'keyword',
        'bibliography',
        'file',
        'status',
        'acc_at',
        'abstrak_id',
        'is_published',
        'published_review',
    ];

    public function abstrak()
    {
        return $this->belongsTo(Abstrak::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'paper_users', 'paper_id', 'user_id')->withPivot(['id']);
    }

    public function revisis()
    {
        return $this->hasMany(RevisiPaper::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
