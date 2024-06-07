<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor_master extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "manager_name"
    ];

    protected $table = "editor_master";
}
