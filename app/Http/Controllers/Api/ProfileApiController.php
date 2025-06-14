<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileApiController extends ControllerApi
{

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diambil.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'foto_profil' => asset($user->foto_profil ?? 'uploads/profile.png'),
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();


        if ($user->foto_profil !== 'uploads/profile.png' && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }

        $file = $request->file('foto_profil');
        $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $user->update([
            'foto_profil' => 'uploads/' . $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diubah.',
            'foto_profil' => asset('uploads/' . $filename),
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();

        $currentFoto = basename($user->foto_profil);

        if ($currentFoto !== 'profile.png') {
            $fotoPath = public_path($user->foto_profil);

            if (file_exists($fotoPath)) {
                unlink($fotoPath); 
            }

            $user->update(['foto_profil' => 'uploads/profile.png']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil dihapus dan dikembalikan ke default.',
            'foto_profil' => asset('uploads/profile.png'), 
        ]);
    }
}
