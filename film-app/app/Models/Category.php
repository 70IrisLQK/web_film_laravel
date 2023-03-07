<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    public function movies()
    {
        return $this->hasMany(Movie::class)->orderBy('id', "DESC");
    }
}