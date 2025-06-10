<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->foto_profil !== 'profile.png' && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }

        $file = $request->file('foto_profil');
        $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $user->update([
            'foto_profil' => 'uploads/' . $filename,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Foto berhasil diubah.');
    }

    public function destroy()
    {
        $user = Auth::user();

        if ($user->foto_profil !== 'profile.png' && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }

        $user->update(['foto_profil' => 'profile.png']);

        return redirect()->route('profile.edit')->with('success', 'Foto berhasil dihapus.');
    }
}
