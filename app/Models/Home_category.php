<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home_category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'category_id'
    ];

    public $timestamps = false;

    protected $table = 'home_categories';

}
