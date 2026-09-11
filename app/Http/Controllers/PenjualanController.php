<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $penjualan = Penjualan::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('pelanggan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $produk = Produk::where('stok', '>', 0)->get();
        
        return view('penjualan.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan'         => 'nullable|string',
            'metode_pembayaran' => 'required|string',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id', // Menggunakan nama tabel 'produk'
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $totalKalkulasi = 0;

            foreach ($request->items as $item) {
                $produkItem = Produk::find($item['produk_id']);
                if ($produkItem) {
                    $qty = $item['qty'] ?? $item['jumlah'] ?? 1;
                    $hargaJual = $produkItem->harga_jual ?? $produkItem->harga ?? 0;
                    
                    $totalKalkulasi += ($hargaJual * $qty);

                    $produkItem->decrement('stok', $qty);
                }
            }

            $totalHarga = $totalKalkulasi > 0 ? $totalKalkulasi : ($request->total_harga ?? 0);
            $bayar = $request->bayar ?? $totalHarga;
            $kembalian = $bayar - $totalHarga;

            Penjualan::create([
                'user_id'           => Auth::id() ?? 1,
                'pelanggan'         => $request->pelanggan ?? 'Pelanggan Umum',
                'metode_pembayaran' => $request->metode_pembayaran ?? 'Tunai (Cash)',
                'total_harga'       => $totalHarga,
                'total_pembayaran'  => $totalHarga,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian < 0 ? 0 : $kembalian,
            ]);
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}