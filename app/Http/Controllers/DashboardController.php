<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanPenjualanService;
use App\Services\MonitoringStokService;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected LaporanPenjualanService $laporanService,
        protected MonitoringStokService $stokService
    ) {}

    public function index()
    {
        $ringkasan = $this->laporanService->ringkasanHariIni();

        return view('dashboard', [
            'tanggalHariIni' => Carbon::now(),
            
            // Menguraikan data ringkasan ke variabel yang dibaca Blade
            'totalPenjualan' => $ringkasan->total_penjualan ?? $ringkasan['total_penjualan'] ?? 0,
            'totalTransaksi' => $ringkasan->total_transaksi ?? $ringkasan['total_transaksi'] ?? 0,
            'pembayaranCash' => $ringkasan->total_cash ?? $ringkasan['total_cash'] ?? 0,
            'nonTunai'       => $ringkasan->total_non_tunai ?? $ringkasan['total_non_tunai'] ?? 0,

            // Penyesuaian nama variabel agar pas dengan file Blade
            'stokRendah'     => $this->stokService->produkStokRendah(),
            'produkHabis'    => $this->stokService->produkStokHabis(),
            'bestSeller'     => $this->laporanService->produkTerlarisHariIni(),
        ]);
    }
}