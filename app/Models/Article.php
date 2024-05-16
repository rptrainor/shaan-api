<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'title', 'description', 'body', 'author_full_name', 'cover_img_src', 'cover_img_alt', 'is_active', 'published_date', 'read_time',
    ];

    /**
     * The "boot" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}
