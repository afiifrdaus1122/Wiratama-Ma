<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string|null $gallery_category
 * @property string $image
 * @property array|null $images
 * @property string|null $description
 */
class Gallery extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
    ];
}
