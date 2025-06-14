<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use Illuminate\Http\Request;
use App\Models\ClaimUser;     // Don't forget to import the models!
use App\Models\ClaimResponse; // Don't forget to import the models!

class ClaimResponseApiController extends ControllerApi
{
    /**
     * Retrieves a list of claims for admin use (GET /admin/claims).
     * Returns a JSON response containing a list of claims with their relations.
     */
    public function index()
    {
        // Fetch all user claims, eager loading their related user, claimResponse, and foundedItem.
        $claims = ClaimUser::with('user', 'claimResponse', 'foundedItem')->get();

        // Format the claim data into a clean array for the JSON response.
        $formattedClaims = $claims->map(function ($claim) {
            return [
                'id' => $claim->id,
                'user' => $claim->user ? [
                    'id' => $claim->user->id,
                    'name' => $claim->user->name,
                    'email' => $claim->user->email,
                ] : null,
                'founded_item' => $claim->foundedItem ? [
                    'id' => $claim->foundedItem->id,
                    'found_item_name' => $claim->foundedItem->found_item_name,
                    'item_type' => $claim->foundedItem->item_type,
                    'item_photo_url' => $claim->foundedItem->item_photo ? asset('storage/' . $claim->foundedItem->item_photo) : null,
                ] : null,
                'claim_response' => $claim->claimResponse ? [
                    'id' => $claim->claimResponse->id,
                    'status' => $claim->claimResponse->status,
                    'created_at' => $claim->claimResponse->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $claim->claimResponse->updated_at->format('Y-m-d H:i:s'),
                ] : null,
                'claim_date' => $claim->claim_date,
                'status_claim_user' => $claim->status, // Status from ClaimUser model
                'description' => $claim->description,
                'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $claim->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Return the JSON response with the list of formatted claims.
        return response()->json([
            'success' => true,
            'message' => 'List of claims for admin retrieved successfully.',
            'data' => $formattedClaims,
        ], 200);
    }

    /**
     * Retrieves details of a specific claim (GET /admin/claims/{id}/edit).
     * While the route is 'edit', for an API, this serves as a 'show detail' function.
     */
    public function edit($id)
    {
        // Find the claim by ID, eager loading related data.
        $claim = ClaimUser::with('user', 'claimResponse', 'foundedItem')->find($id);

        // If the claim is not found, return a 404 Not Found JSON response.
        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Claim not found.',
                'data' => null
            ], 404);
        }

        // Format the single claim's data for the JSON response.
        $formattedClaim = [
            'id' => $claim->id,
            'user' => $claim->user ? [
                'id' => $claim->user->id,
                'name' => $claim->user->name,
                'email' => $claim->user->email,
            ] : null,
            'founded_item' => $claim->foundedItem ? [
                'id' => $claim->foundedItem->id,
                'found_item_name' => $claim->foundedItem->found_item_name,
                'item_type' => $claim->foundedItem->item_type,
                'item_photo_url' => $claim->foundedItem->item_photo ? asset('storage/' . $claim->foundedItem->item_photo) : null,
            ] : null,
            'claim_response' => $claim->claimResponse ? [
                'id' => $claim->claimResponse->id,
                'status' => $claim->claimResponse->status,
                'created_at' => $claim->claimResponse->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $claim->claimResponse->updated_at->format('Y-m-d H:i:s'),
            ] : null,
            'claim_date' => $claim->claim_date,
            'status_claim_user' => $claim->status,
            'description' => $claim->description,
            'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $claim->updated_at->format('Y-m-d H:i:s'),
        ];

        // Return the JSON response with the claim details.
        return response()->json([
            'success' => true,
            'message' => 'Claim details retrieved successfully.',
            'data' => $formattedClaim,
        ], 200);
    }

    /**
     * Updates the status of a claim's response (PUT /admin/claims/{id}).
     * This route effectively handles the 'storeOrUpdate' functionality for API.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request for the 'status' field.
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Find the ClaimUser by ID, or throw an exception if not found.
        $claim = ClaimUser::findOrFail($id);

        // Update or create the ClaimResponse for the given claim.
        // This makes the operation idempotent.
        $claimResponse = ClaimResponse::updateOrCreate(
            ['claim_user_id' => $claim->id], // Condition to find the existing response
            ['status' => $request->status]   // Data to update or create
        );

        // Return a JSON response confirming the successful update and the updated data.
        return response()->json([
            'success' => true,
            'message' => 'Claim response status updated successfully.',
            'data' => [
                'id' => $claimResponse->id,
                'claim_user_id' => $claimResponse->claim_user_id,
                'status' => $claimResponse->status,
                'created_at' => $claimResponse->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $claimResponse->updated_at->format('Y-m-d H:i:s'),
            ],
        ], 200); // 200 OK is standard for successful PUT/UPDATE.
    }

    public function destroy($id)
    {
        // Cari ClaimUser berdasarkan ID.
        // Jika klaim user tidak ditemukan, tidak ada respons klaim yang bisa dihapus.
        $claim = ClaimUser::find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Klaim user tidak ditemukan.',
                'data' => null
            ], 404);
        }

        // Pastikan ada respons klaim terkait dengan ClaimUser ini.
        if (!$claim->claimResponse) {
            return response()->json([
                'success' => false,
                'message' => 'Respons klaim tidak ditemukan untuk klaim ini.',
                'data' => null
            ], 404);
        }

        // Otorisasi: Pastikan hanya admin yang bisa menghapus respons klaim.
        // Asumsi: Jika user yang terautentikasi adalah admin.
        // Anda perlu menyesuaikan ini dengan cara Anda mendefinisikan peran admin.
        // Contoh sederhana: if (Auth::check() && Auth::user()->role !== 'admin') { ... }
        // Atau gunakan Laravel Policies untuk otorisasi yang lebih kompleks.
        // Untuk tujuan API admin, kita asumsikan middleware sudah cukup atau user memiliki akses.

        $claimResponseId = $claim->claimResponse->id; // Ambil ID respons sebelum dihapus
        $claim->claimResponse->delete(); // Hapus respons klaim

        return response()->json([
            'success' => true,
            'message' => 'Respons klaim berhasil dihapus.',
            'data' => ['id' => $claimResponseId] // Mengembalikan ID respons yang dihapus
        ], 200); // 200 OK adalah respons yang umum, 204 No Content juga bisa.
    }

    // The 'destroy' method is commented out as there's no explicit DELETE route
    // in your provided routes/api.php that maps to this controller for deleting a claim response.
    // If you need this functionality, a corresponding DELETE route would need to be added.
    /*
    public function destroy($id)
    {
        $claim = ClaimUser::findOrFail($id);

        if ($claim->claimResponse) {
            $claimResponseId = $claim->claimResponse->id;
            $claim->claimResponse->delete();

            return response()->json([
                'success' => true,
                'message' => 'Claim response deleted successfully.',
                'data' => ['id' => $claimResponseId]
            ], 200); // Or 204 No Content for successful deletion
        }

        return response()->json([
            'success' => false,
            'message' => 'Claim response not found for this claim.',
            'data' => null
        ], 404); // 404 Not Found if the response doesn't exist
    }
    */
}