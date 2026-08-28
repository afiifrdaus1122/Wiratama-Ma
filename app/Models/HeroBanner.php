<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $page
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $desktop_image
 * @property string|null $mobile_image
 * @property string $background_type
 * @property string|null $background_value
 * @property string|null $cta_text
 * @property string|null $cta_url
 * @property string $cta_target
 * @property string $overlay_color
 * @property float $overlay_opacity
 * @property string $position
 * @property int $height_vh
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 */
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
