<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
{
    public function index(): View
    {
        return view('tentang.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada di storage (opsional)
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru ke folder storage/app/public/profile
            $path = $request->file('foto')->store('profile', 'public');
            $user->foto = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}