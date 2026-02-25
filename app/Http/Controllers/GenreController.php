<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.genre.index', [
            'title' => 'Genre List',
            'genres' => Genre::with('mangas')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect('/genre');

        // return view('pages.genre.create', [
        //     'title' => 'Add Genre'
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:genres'
        ]);

        Genre::create($validatedData);

        return redirect('/genre')->with('success', 'Genre has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return redirect('/genre');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return redirect('/genre');
        
        // return view('pages.genre.edit', [
        //     'title' => 'Edit Genre',
        //     'genre' => $genre
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if($request->slug != $genre->slug){
            $rules['slug'] = 'required|unique:genres';
        }

        $validatedData = $request->validate($rules);

        Genre::where('id', $genre->id)->update($validatedData);

        return back()->with('success', 'Genre has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $mangas = $genre->mangas()->get();

        foreach ($mangas as $manga) {
            $manga->delete();
        }

        Genre::destroy($genre->id);

        return back()->with('success', 'Genre has been deleted.');
    }
}


