<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimApiController extends Controller
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
