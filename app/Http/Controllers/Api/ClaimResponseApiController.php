<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use Illuminate\Http\Request;

class ClaimResponseApiController extends ControllerApi
{
    /**
     * Menyimpan atau memperbarui response dari admin terhadap klaim.
     */

    public function index()
    {
        $claims = ClaimUser::with('user', 'claimResponse', 'foundedItem')->get();
        return view('claim_items.response', compact('claims'));
    }

    public function storeOrUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim = ClaimUser::findOrFail($id);

        ClaimResponse::updateOrCreate(
            ['claim_user_id' => $claim->id],
            ['status' => $request->status]
        );

        return redirect()->route('admin.claim_items.index')->with('success', 'Status klaim diperbarui.');
    }

    public function destroy($id)
    {
        $claim = ClaimUser::findOrFail($id);

        if ($claim->claimResponse) {
            $claim->claimResponse->delete();
            return redirect()->route('admin.claim_items.index')->with('success', 'Respons klaim dihapus.');
        }

        return redirect()->route('admin.claim_items.index')->with('error', 'Respons klaim tidak ditemukan.');
    }
}
