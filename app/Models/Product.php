<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $sku
 * @property string|null $description
 * @property string|null $specification
 * @property string|null $image
 * @property string|null $datasheet
 * @property string|null $brand
 * @property string|null $video_url
 * @property string $slug
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property float|int $price
 * @property int $stock
 * @property bool $is_active
 * @property-read Category|null $category
 * @property-read SubCategory|null $subCategory
 * @property-read ProductQuestion[] $questions
 * @property-read ProductAttribute[] $attributes
 * @property-read ProductImage[] $images
 * @property-read Article[] $articles
 */
class Product extends Model
{
    protected $fillable = [
        'category_id', 'sub_category_id', 'name', 'slug', 'sku', 'description', 'specification',
        'price', 'stock', 'is_active', 'brand', 'image', 'datasheet', 'video_url',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function questions()
    {
        return $this->hasMany(ProductQuestion::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
