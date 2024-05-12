<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id',
        'slug',
        'title',
        'description',
        'body',
        'author_full_name',
        'cover_img_src',
        'cover_img_alt',
        'is_active',
        'published_date'
    ];

    // In your Article model
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}
