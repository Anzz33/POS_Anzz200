<?php

namespace App\Services;

use App\Models\Produk;

class MonitoringStokService
{
    public function produkStokRendah(int $batas = 5)
    {
        return Produk::where('stok', '>', 0)
            ->where('stok', '<=', $batas)
            ->orderBy('stok', 'asc')
            ->get();
    }

    public function produkStokHabis()
    {
        return Produk::where('stok', '<=', 0)
            ->orWhereNull('stok')
            ->orderBy('nama', 'asc') 
            ->get();
    }
}