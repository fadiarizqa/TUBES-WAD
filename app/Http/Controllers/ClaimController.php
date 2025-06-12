<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        return Claim::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required',
            'action' => 'required',
            'item_id' => 'required|integer',
            'message' => 'nullable|string',
            'status' => 'required|string'
        ]);

        return Claim::create($validated);
    }

    public function show(Claim $claim)
    {
        return $claim;
    }

    public function update(Request $request, Claim $claim)
    {
        $claim->update($request->all());
        return $claim;
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return response()->noContent();
    }
}
