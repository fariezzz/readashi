<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use Faker\Factory as FakerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MangaApiController extends Controller
{
    public function index()
    {
        return response()->json(Manga::with('genre')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'genre_id' => 'required|exists:genres,id',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'synopsis' => 'nullable|max:255',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|file|max:1024',
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Manga::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        }
        $validated['code'] = $uniqueCode;

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('manga-images', 'public');
        }

        $manga = Manga::create($validated);

        return response()->json($manga->load('genre'), 201);
    }

    public function show(int $id)
    {
        $manga = Manga::with('genre')->findOrFail($id);

        return response()->json($manga);
    }

    public function update(Request $request, int $id)
    {
        $manga = Manga::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'genre_id' => 'required|exists:genres,id',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'synopsis' => 'nullable|max:255',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|file|max:1024',
        ]);

        if ($request->file('image')) {
            if ($manga->image) {
                Storage::disk('public')->delete($manga->image);
            }
            $validated['image'] = $request->file('image')->store('manga-images', 'public');
        }

        $manga->update($validated);

        return response()->json($manga->load('genre'));
    }

    public function destroy(int $id)
    {
        $manga = Manga::findOrFail($id);

        if ($manga->image) {
            Storage::disk('public')->delete($manga->image);
        }

        $manga->delete();

        return response()->json(['message' => 'Manga deleted']);
    }
}
