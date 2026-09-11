<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:1'
        ]);

        // 1. Cari transaksi OPEN milik kasir
        $sale = Penjualan::where('user_id', Auth::id())
            ->where('status', 'OPEN')
            ->first();

        if (!$sale) {
            return back()->with('error', 'Transaksi aktif tidak ditemukan.');
        }

        // 2. Cari produk
        $product = Produk::find($request->product_id);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        // 3. Cek stok sebelum transaksi (di luar DB::transaction)
        if ($product->stok < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi (Sisa stok: ' . $product->stok . ')');
        }

        // 4. Proses simpan ke keranjang & kurangi stok
        DB::transaction(function () use ($request, $sale, $product) {
            // Kurangi stok produk
            $product->decrement('stok', $request->quantity);

            // Cek apakah item sudah ada di keranjang
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->first();

            if ($item) {
                $item->kuantitas += $request->quantity;
            } else {
                $item = new ItemPenjualan();
                $item->penjualan_id = $sale->id;
                $item->produk_id    = $product->id;
                $item->kuantitas    = $request->quantity;
                $item->harga_satuan = $product->harga_jual;
            }

            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            // Update total pembayaran di tabel penjualan
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = $itempenjualan->produk;
        $selisih = $request->quantity - $itempenjualan->kuantitas;

        // Cek stok jika jumlah ditambah
        if ($selisih > 0 && $product->stok < $selisih) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        DB::transaction(function () use ($request, $itempenjualan, $product, $selisih) {
            if ($selisih > 0) {
                $product->decrement('stok', $selisih);
            } elseif ($selisih < 0) {
                $product->increment('stok', abs($selisih));
            }

            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
            ]);

            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Jumlah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        DB::transaction(function () use ($itempenjualan) {
            $product = $itempenjualan->produk;
            $sale    = $itempenjualan->penjualan;

            if ($product) {
                $product->increment('stok', $itempenjualan->kuantitas);
            }

            $itempenjualan->delete();

            if ($sale) {
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            }
        });

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}