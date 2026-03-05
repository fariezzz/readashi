<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingApiController extends Controller
{
    public function index()
    {
        return response()->json(Borrowing::with(['member', 'manga'])->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'manga_id' => 'required|exists:mangas,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'fine' => 'nullable|integer|min:0',
            'status' => 'required|in:borrowed,returned,late',
        ]);

        $validated['fine'] = $validated['fine'] ?? 0;
        $borrowing = Borrowing::create($validated);

        return response()->json($borrowing->load(['member', 'manga']), 201);
    }

    public function show(int $id)
    {
        return response()->json(Borrowing::with(['member', 'manga'])->findOrFail($id));
    }

    public function update(Request $request, int $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'manga_id' => 'required|exists:mangas,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'fine' => 'nullable|integer|min:0',
            'status' => 'required|in:borrowed,returned,late',
        ]);

        $validated['fine'] = $validated['fine'] ?? 0;
        $borrowing->update($validated);

        return response()->json($borrowing->load(['member', 'manga']));
    }

    public function destroy(int $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return response()->json(['message' => 'Borrowing deleted']);
    }
}
