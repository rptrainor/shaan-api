<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'body',
        'author_full_name',
        'cover_img_src',
        'cover_img_alt',
        'is_active',
        'published_date'
    ];
}