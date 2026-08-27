<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'stats' => 'array',
        'features' => 'array',
        'about_images' => 'array',
    ];
}
