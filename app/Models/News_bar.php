<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_bar extends Model
{
    use HasFactory;
    protected $fillable = [
        "text"
    ];

    public $timestamps = false;
}
