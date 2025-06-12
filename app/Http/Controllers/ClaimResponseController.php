<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimResponseController extends Controller
{
    public function index()
    {
        $claims = ClaimUser::with('response')->get(); // ambil semua klaim beserta responsenya
        return view('claim_items.response', compact('claims'));
    }

    public function edit($id)
    {
        $claim = ClaimUser::with('response')->findOrFail($id);
        return view('claim_items.edit_response', compact('claim'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'message' => 'nullable|string',
        ]);

        $claim = ClaimUser::findOrFail($id);

        $responseData = [
            'status' => $request->status,
            'message' => $request->message,
        ];

        // Kalau sudah pernah diberi response, update
        if ($claim->response) {
            $claim->response->update($responseData);
        } else {
            $claim->response()->create($responseData);
        }

        return redirect()->route('admin.claims.index')->with('success', 'Response berhasil disimpan!');
    }
}