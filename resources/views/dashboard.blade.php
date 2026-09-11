@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Hilangkan background pekat pembungkus utama */
    html, body, #app, main, 
    .main-content, .content-wrapper, .content, 
    .container, .container-fluid, .page-content,
    div[class*="content"], div[class*="wrapper"] {
        background-color: transparent !important;
    }

    body {
        background: linear-gradient(rgba(10, 10, 12, 0.75), rgba(10, 10, 12, 0.85)), 
                    url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* Card Utama Glassmorphism Dark */
    .dashboard-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* Sub Cards */
    .dash-box {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* Stat Cards */
    .stat-box {
        background: rgba(15, 17, 23, 0.5) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px !important;
        transition: transform 0.2s ease;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(212, 175, 55, 0.15);
        color: #d4af37;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Tabel Transparan */
    .table-dash {
        color: #ffffff !important;
        background-color: transparent !important;
        vertical-align: middle;
    }

    .table-dash th {
        background-color: rgba(15, 17, 23, 0.8) !important;
        color: #a0aec0 !important;
        font-size: 0.7rem;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .table-dash td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
        font-size: 0.85rem;
    }

    .table-dash tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    /* Rank Badges */
    .rank-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.75rem;
    }
    .rank-1 { background-color: #d4af37; color: #000; }
    .rank-2 { background-color: #a0aec0; color: #000; }
    .rank-3 { background-color: #cd7f32; color: #fff; }
    .rank-other { background-color: rgba(255, 255, 255, 0.1); color: #a0aec0; }
</style>

<div class="card dashboard-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Top Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <span class="badge bg-warning text-dark fw-bold mb-2 px-2 py-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">CAFE & STORE POS SYSTEM</span>
                <h2 class="fw-bold text-white mb-1">Dashboard Overview</h2>
                <p class="mb-0 small text-white-50">
                    Selamat Datang, <span class="text-white fw-semibold">{{ Auth::user()->name ?? 'User' }}</span> 
                    &bull; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} 
                    &bull; {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                </p>
            </div>
            <div>
                <a href="{{ route('penjualan.create') ?? '#' }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.85rem;">
                    <span>+</span> Transaksi Baru
                </a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
            <!-- Total Penjualan -->
            <div class="col-md-3">
                <div class="stat-box p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase small text-white-50 fw-semibold d-block mb-1" style="font-size: 0.7rem;">Total Penjualan</span>
                        <h4 class="fw-bold text-white mb-0">Rp {{ number_format($totalPenjualan ?? 4306000, 0, ',', '.') }}</h4>
                    </div>
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-md-3">
                <div class="stat-box p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase small text-white-50 fw-semibold d-block mb-1" style="font-size: 0.7rem;">Total Transaksi</span>
                        <h4 class="fw-bold text-white mb-0">{{ $totalTransaksi ?? 23 }}</h4>
                    </div>
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Cash -->
            <div class="col-md-3">
                <div class="stat-box p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase small text-white-50 fw-semibold d-block mb-1" style="font-size: 0.7rem;">Pembayaran Cash</span>
                        <h4 class="fw-bold text-white mb-0">Rp {{ number_format($pembayaranCash ?? 1273000, 0, ',', '.') }}</h4>
                    </div>
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Non Tunai -->
            <div class="col-md-3">
                <div class="stat-box p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase small text-white-50 fw-semibold d-block mb-1" style="font-size: 0.7rem;">Non Tunai</span>
                        <h4 class="fw-bold text-white mb-0">Rp {{ number_format($nonTunai ?? 3033000, 0, ',', '.') }}</h4>
                    </div>
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Tengah: Stok Rendah & Produk Habis -->
        <div class="row g-3 mb-4">
            <!-- Produk Stok Rendah -->
            <div class="col-md-6">
                <div class="dash-box p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-warning">⚠️</span>
                            <h6 class="fw-bold text-white m-0">Produk Stok Rendah</h6>
                        </div>
                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Peringatan</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dash mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">NO</th>
                                    <th>PRODUK</th>
                                    <th class="text-end">SISA STOK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stokRendah ?? [
                                    (object)['nama_produk' => 'Kentang Goreng Original', 'stok' => 2],
                                    (object)['nama_produk' => 'Donat Kentang Glaze', 'stok' => 3],
                                    (object)['nama_produk' => 'Matcha Ice Latte', 'stok' => 5],
                                ] as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-white">{{ $item->nama_produk ?? $item->nama }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-25 px-2 py-1">
                                                {{ $item->stok }} Pcs
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-white-50">Tidak ada stok rendah</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Produk Habis -->
            <div class="col-md-6">
                <div class="dash-box p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-danger">🚫</span>
                            <h6 class="fw-bold text-white m-0">Produk Habis</h6>
                        </div>
                        <span class="badge bg-danger text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Kosong</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dash mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">NO</th>
                                    <th>PRODUK</th>
                                    <th class="text-end">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkHabis ?? [
                                    (object)['nama_produk' => 'Kopi Americano Hot', 'stok' => 0],
                                ] as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-white">{{ $item->nama_produk ?? $item->nama }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25 px-2 py-1">
                                                Habis (0)
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-white-50">Tidak ada produk habis</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Bawah: Best Seller Products -->
        <div class="dash-box p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">🏆</span>
                    <h6 class="fw-bold text-white m-0">Best Seller Products</h6>
                </div>
                <span class="badge bg-secondary text-white-50 px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Top Terlaris</span>
            </div>
            <div class="table-responsive">
                <table class="table table-dash mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">RANK</th>
                            <th>NAMA PRODUK</th>
                            <th class="text-center">SISA STOK</th>
                            <th class="text-end">TOTAL TERJUAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bestSeller ?? [
                            (object)['nama_produk' => 'Es Teh Manis', 'stok' => 50, 'terjual' => 63],
                            (object)['nama_produk' => 'Air Mineral 600ml', 'stok' => 100, 'terjual' => 47],
                            (object)['nama_produk' => 'Ayam Geprek Sambal Korek', 'stok' => 20, 'terjual' => 40],
                            (object)['nama_produk' => 'Kopi Americano Hot', 'stok' => 0, 'terjual' => 36],
                            (object)['nama_produk' => 'Roti Bakar Cokelat Keju', 'stok' => 15, 'terjual' => 31],
                        ] as $index => $item)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="fw-semibold text-white">{{ $item->nama_produk ?? $item->nama }}</td>
                                <td class="text-center text-white-50">{{ $item->stok }} Pcs</td>
                                <td class="text-end fw-bold text-warning">{{ $item->total_terjual ?? $item->terjual ?? 0 }} terjual</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-white-50">Belum ada data penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.dashboard-card-main');
        if (card) {
            let parent = card.parentElement;
            while (parent && parent !== document.body) {
                parent.style.setProperty('background-color', 'transparent', 'important');
                parent.style.setProperty('background-image', 'none', 'important');
                parent.classList.remove('bg-white', 'bg-light', 'bg-body', 'bg-dark');
                parent = parent.parentElement;
            }
        }
    });
</script>
@endsection