<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = [
        'ad_1',
        'ad_2',
        'ad_3',
        'mobile_ad_1',
        'mobile_ad_2',
        'mobile_ad_3',
        'main_ad',
    ];

    public $timestamps = false;
}
