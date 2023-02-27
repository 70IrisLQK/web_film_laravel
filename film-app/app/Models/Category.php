<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function movies()
    {
        return $this->hasMany(Movie::class)->orderBy('id', "DESC");
    }

    use HasFactory;
}