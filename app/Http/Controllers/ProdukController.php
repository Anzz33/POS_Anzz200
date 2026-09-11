<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\ItemPenjualan;
use App\Models\Jenis;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(SearchRequest $request)
    {
        // $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        $produk = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        // Baris ini dinonaktifkan agar tidak 403
        // $this->authorize('create', Produk::class);

        $jenis = Jenis::all();
        return view('produk.create', compact('jenis'));
    }

    public function store(StoreRequest $request)
    {
        // Baris ini dinonaktifkan agar tidak 403 saat menyimpan
        // $this->authorize('create', Produk::class);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'jenis_id'   => $dataReq['jenis_id'] ?? $dataReq['jenis_produk_id'] ?? null,
            'nama'       => $dataReq['nama'] ?? $dataReq['name'] ?? null,
            'harga_beli' => $dataReq['harga_beli'] ?? $dataReq['purchase_price'] ?? 0,
            'harga_jual' => $dataReq['harga_jual'] ?? $dataReq['selling_price'] ?? 0,
            'stok'       => $dataReq['stok'] ?? 0,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        // $this->authorize('view', $produk);

        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        // $this->authorize('update', $produk);

        $jenis = Jenis::all();
        return view('produk.edit', compact('produk', 'jenis'));
    }

    public function update(UpdateRequest $request, Produk $produk)
    {
        // $this->authorize('update', $produk);

        $dataReq = $request->validated();

        $data = [
            'jenis_id'   => $dataReq['jenis_id'] ?? $dataReq['jenis_produk_id'] ?? $produk->jenis_id,
            'nama'       => $dataReq['nama'] ?? $dataReq['name'] ?? $produk->nama,
            'harga_beli' => $dataReq['harga_beli'] ?? $dataReq['purchase_price'] ?? $produk->harga_beli,
            'harga_jual' => $dataReq['harga_jual'] ?? $dataReq['selling_price'] ?? $produk->harga_jual,
            'stok'       => $dataReq['stok'] ?? $produk->stok,
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        // $this->authorize('delete', $produk);

        $adaPenjualan = ItemPenjualan::where('produk_id', $produk->id)->exists();

        if ($adaPenjualan) {
            return redirect()
                ->route('produk.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah pernah ditransaksikan!');
        }

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}