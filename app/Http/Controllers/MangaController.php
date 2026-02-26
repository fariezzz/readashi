<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Gate;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.manga.index', [
            'title' => 'Manga List',
            'mangas' => Manga::latest()->filter(request(['search', 'genre']))->with('genre')->paginate(8)->withQueryString(),
            'genres' => Genre::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('admin')) {
            return redirect('/manga');
        }
        
        return view('pages.manga.create', [
            'title' => 'Add Item',
            'genres' => Genre::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('admin')) {
            return redirect('/manga')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'genre_id' => 'required',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'synopsis' => 'max:255|nullable',
            'stock' => 'required|integer|min:0',
            'image' => 'image|file|max:1024'
        ]);

        $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        while (Manga::where('code', $uniqueCode)->exists()) {
            $uniqueCode = FakerFactory::create()->unique()->numerify('###########');
        }
        $validatedData['code'] = $uniqueCode;

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('manga-images', 'public');
        }

        Manga::create($validatedData);

        return redirect('/manga')->with('success', 'Item has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manga $manga)
    {
        return redirect('/manga');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        if (! Gate::allows('admin')) {
            return redirect('/manga');
        }

        $decryptedCode = decrypt($code);
        $manga = Manga::where('code', $decryptedCode)->firstOrFail();

        return view('pages.manga.edit', [
            'title' => 'Edit Item',
            'manga' => $manga,
            'genres' => Genre::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        if (! Gate::allows('admin')) {
            return redirect('/manga')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'genre_id' => 'required',
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'synopsis' => 'max:255|nullable',
            'stock' => 'required|integer|min:0',
            'image' => 'image|file|max:1024'
        ]);

        if($request->file('image')){
            if($manga->image){
                Storage::disk('public')->delete($manga->image);
            }
            $validatedData['image'] = $request->file('image')->store('manga-images', 'public');
        }

        Manga::where('id', $manga->id)->update($validatedData);

        return redirect('/manga')->with('success', 'Item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        if (! Gate::allows('admin')) {
            return redirect('/manga')->with('error', 'You do not have permission to perform this action.');
        }

        if ($manga->image) {
            Storage::delete($manga->image);
        }

        $manga->delete();
    
        return back()->with('success', 'Item has been deleted.');
    }

    public function updateStock(Request $request, $id) {
        $manga = Manga::findOrFail($id);

        $validatedData = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $manga->stock = $validatedData['stock'];
        $manga->save();

        return back()->with('success', 'Stock has been updated.');
    }
}


