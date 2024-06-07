<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Important_article extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id'
    ];

    public $table = 'important_articles';

    public function article()
    {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

}
