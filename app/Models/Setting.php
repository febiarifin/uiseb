<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'information',
        'template_abstract',
        'template_full_paper',
        'template_video',
        'confirmation_letter',
        'copyright_letter',
        'self_declare_letter',
        'flayer',
    ];

}
