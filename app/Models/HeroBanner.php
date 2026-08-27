<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'page', 'title', 'subtitle', 'description', 
        'desktop_image', 'mobile_image', 'background_type', 
        'background_value', 'cta_text', 'cta_url', 'cta_target',
        'overlay_color', 'overlay_opacity', 'position', 'height_vh',
        'is_active', 'sort_order', 'start_date', 'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'overlay_opacity' => 'float',
    ];
}
