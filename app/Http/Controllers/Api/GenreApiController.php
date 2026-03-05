<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreApiController extends Controller
{
    public function index()
    {
        return response()->json(Genre::with('mangas')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:genres,slug',
        ]);

        $genre = Genre::create($validated);

        return response()->json($genre, 201);
    }

    public function show(int $id)
    {
        $genre = Genre::with('mangas')->findOrFail($id);

        return response()->json($genre);
    }

    public function update(Request $request, int $id)
    {
        $genre = Genre::findOrFail($id);

        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required',
        ];

        if ($request->slug !== $genre->slug) {
            $rules['slug'] = 'required|unique:genres,slug';
        }

        $validated = $request->validate($rules);
        $genre->update($validated);

        return response()->json($genre);
    }

    public function destroy(int $id)
    {
        $genre = Genre::with('mangas')->findOrFail($id);

        foreach ($genre->mangas as $manga) {
            $manga->delete();
        }

        $genre->delete();

        return response()->json(['message' => 'Genre deleted']);
    }
}
