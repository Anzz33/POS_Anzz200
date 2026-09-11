<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::with('user')->latest()->paginate(10);
        return view('jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
        ]);

        Jenis::create([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi,
            'user_id'    => auth()->id(),
        ]);

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
        ]);

        $jenis = Jenis::findOrFail($id);
        $jenis->update([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil dihapus.');
    }
}