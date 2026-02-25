<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.member.index', [
            'title' => 'Member List',
            'members' => Member::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect('/member');

        // return view('pages.member.create', [
        //     'title' => 'Add Member',
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required'
        ]);

        Member::create($validatedData);

        return redirect('/member')->with('success', 'Member has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return redirect('/member');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return redirect('/member');

        // return view('pages.member.edit', [
        //     'title' => 'Edit Member',
        //     'Member' => $member
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required'
        ]);

        Member::where('id', $member->id)->update($validatedData);

        return redirect('/member')->with('success', 'Member has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        if (! Gate::allows('admin')) {
            return redirect('/member')->with('error', 'You do not have permission to perform this action.');
        }

        Member::destroy($member->id);

        return back()->with('success', 'Member has been deleted.');
    }
}


