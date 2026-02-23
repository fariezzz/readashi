<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.borrowing.index', [
            'title' => 'Borrowing List',
            'borrowings' => Borrowing::with(['customer', 'product'])->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('admin')) {
            return redirect('/borrowing');
        }

        return view('pages.borrowing.create', [
            'title' => 'Add Borrowing',
            'customers' => Customer::all(),
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('admin')) {
            return redirect('/borrowing')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'fine' => 'nullable|integer|min:0',
            'status' => 'required|in:borrowed,returned,late'
        ]);

        $validatedData['fine'] = $validatedData['fine'] ?? 0;

        Borrowing::create($validatedData);

        return redirect('/borrowing')->with('success', 'Borrowing has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        return redirect('/borrowing');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        if (! Gate::allows('admin')) {
            return redirect('/borrowing');
        }

        return view('pages.borrowing.edit', [
            'title' => 'Edit Borrowing',
            'borrowing' => $borrowing,
            'customers' => Customer::all(),
            'products' => Product::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        if (! Gate::allows('admin')) {
            return redirect('/borrowing')->with('error', 'You do not have permission to perform this action.');
        }

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'fine' => 'nullable|integer|min:0',
            'status' => 'required|in:borrowed,returned,late'
        ]);

        $validatedData['fine'] = $validatedData['fine'] ?? 0;

        Borrowing::where('id', $borrowing->id)->update($validatedData);

        return redirect('/borrowing')->with('success', 'Borrowing has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        if (! Gate::allows('admin')) {
            return redirect('/borrowing')->with('error', 'You do not have permission to perform this action.');
        }

        Borrowing::destroy($borrowing->id);

        return back()->with('success', 'Borrowing has been deleted.');
    }
}
