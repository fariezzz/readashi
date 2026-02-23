<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action',
            'Adventure',
            'Comedy',
            'Drama',
            'Fantasy',
            'Isekai',
            'Romance',
            'Slice of Life',
        ];

        foreach ($genres as $genre) {
            Category::create([
                'name' => $genre,
                'slug' => Str::slug($genre),
            ]);
        }
    }
}
