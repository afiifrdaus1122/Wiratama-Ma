<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $image
 * @property string $content
 * @property string $slug
 * @property int|null $article_category_id
 * @property string|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property bool $is_published
 * @property-read ArticleCategory|null $category
 * @property-read Product[] $products
 */
class Article extends Model
{
    protected $fillable = [
        'user_id', 'article_category_id', 'title', 'slug', 'content', 
        'image', 'published_at', 'meta_title', 'meta_description', 'meta_keywords', 'is_published'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
