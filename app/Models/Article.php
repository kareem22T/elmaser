<?php

namespace App\Models;
use App\Models\Visit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'intro',
        'title',
        'sub_title',
        'content',
        'author_name',
        'author_id',
        'thumbnail_path',
        'thumbnail_title',
        'isDraft',
        'isTrend',
        'category_id'
    ];

    // relationships
    public function author()
    {
        return $this->belongsTo('App\Models\Author', 'author_id');
    }

    public function titles()
    {
        return $this->hasMany('App\Models\Article_Title', 'article_id');
    }

    public function contents()
    {
        return $this->hasMany('App\Models\Article_Content', 'article_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tag', 'article_id', 'tag_id', 'id', 'id');
    }
    public function visits()
    {
        return $this->hasOne(Visit::class, 'article_id');
    }

}
