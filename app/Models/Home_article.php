<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;

class Home_article extends Model
{
    use HasFactory;
    protected $fillable = [
        "article_id",
        "title",
    ];
    public $timestamps = false;

    /**
     * Get the user associated with the Home_article
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'article_id');
    }
}
