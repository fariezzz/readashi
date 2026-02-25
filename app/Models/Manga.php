<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where(function($query) use($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['genre'] ?? false, function($query, $genre){
            $query->whereHas('genre', function($query) use ($genre) {
                $query->where('slug', $genre);
            });
        });
    }
}


