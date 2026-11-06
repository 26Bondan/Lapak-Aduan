<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Aduan; // 👈 1. Import Model Aduan agar tidak Error 500

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 👈 2. Ambil data aduan khusus milik user yang sedang login
        $aduans = Aduan::where('user_id', $user->id)
                        ->latest()
                        ->get();

        // 👈 3. Kirim data $user dan $aduans ke view 'profile'
        return view('profile', compact('user', 'aduans'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->name = $request->name;

        // Cek apakah kolom avatar ada di tabel users sebelum menyimpan
        if ($request->hasFile('avatar') && Schema::hasColumn('users', 'avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}