<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberApiController extends Controller
{
    public function index()
    {
        return response()->json(Member::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
        ]);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }

    public function show(int $id)
    {
        return response()->json(Member::findOrFail($id));
    }

    public function update(Request $request, int $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
        ]);

        $member->update($validated);

        return response()->json($member);
    }

    public function destroy(int $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Member deleted']);
    }
}
