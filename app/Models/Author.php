<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "brief",
        "profile_path",
        "created_at",
    ];

    // relationships
    public function  articles()
    {
        return $this->hasOne('App\Models\Article', 'author_id');
    }



}
