<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mangas(){
        return $this->hasMany(Manga::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}


