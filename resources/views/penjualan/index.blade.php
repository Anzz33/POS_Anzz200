@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
<style>
    /* 1. Background transparan pembungkus utama */
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

    /* 2. Card Utama Glassmorphism */
    .penjualan-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* 3. Sub-box Isian Dalam */
    .penjualan-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* 4. Tabel Transparan */
    .table-penjualan {
        color: #ffffff !important;
        background-color: transparent !important;
    }

    .table-penjualan th {
        background-color: rgba(15, 17, 23, 0.8) !important;
        color: #a0aec0 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .table-penjualan td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
    }

    .table-penjualan tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.04) !important;
    }

    /* Input Cari */
    .input-dark {
        background-color: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    .input-dark::placeholder {
        color: #a0aec0 !important;
    }

    /* Badges */
    .badge-cash {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border: 1px solid rgba(52, 211, 153, 0.4);
    }

    .badge-transfer {
        background-color: rgba(59, 130, 246, 0.2) !important;
        color: #60a5fa !important;
        border: 1px solid rgba(96, 165, 250, 0.4);
    }

    .badge-qris {
        background-color: rgba(168, 85, 247, 0.2) !important;
        color: #c084fc !important;
        border: 1px solid rgba(192, 132, 252, 0.4);
    }
</style>

<div class="card penjualan-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Header Atas -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h2 class="fw-bold text-white mb-1">Riwayat Penjualan</h2>
                <p class="mb-0 small" style="color: #a0aec0 !important;">Daftar riwayat seluruh transaksi kasir POS.</p>
            </div>
            <div>
                <a href="{{ route('penjualan.create') }}" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                    + Transaksi Baru
                </a>
            </div>
        </div>

        <!-- Filter Cari -->
        <div class="penjualan-card-inner p-3 mb-4">
            <form action="{{ route('penjualan.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4 col-12">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control input-dark rounded-3" placeholder="Cari kasir / pelanggan...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary px-4 rounded-3 fw-semibold">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive rounded-3 border border-secondary border-opacity-25">
            <table class="table table-penjualan align-middle mb-0">
                <thead>
                    <tr>
                        <th class="py-3 px-3 text-center" style="width: 50px;">#</th>
                        <th class="py-3 px-3">TANGGAL</th>
                        <th class="py-3 px-3">KASIR</th>
                        <th class="py-3 px-3">PELANGGAN</th>
                        <th class="py-3 px-3 text-center">METODE</th>
                        <th class="py-3 px-3 text-end">TOTAL BELANJA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualan as $index => $item)
                        <tr>
                            <td class="text-center fw-semibold" style="color: #a0aec0 !important;">
                                {{ method_exists($penjualan, 'firstItem') ? $penjualan->firstItem() + $index : $index + 1 }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="fw-semibold text-white">
                                {{ $item->user->name ?? $item->kasir ?? '-' }}
                            </td>
                            <td>
                                {{ $item->pelanggan ?? 'Pelanggan Umum' }}
                            </td>
                            <td class="text-center">
                                @php
                                    $metode = strtoupper($item->metode_pembayaran ?? $item->metode ?? 'CASH');
                                @endphp
                                @if(str_contains($metode, 'CASH') || str_contains($metode, 'TUNAI'))
                                    <span class="badge badge-cash px-3 py-2 rounded-pill fw-semibold fs-8">{{ $metode }}</span>
                                @elseif(str_contains($metode, 'TRANSFER'))
                                    <span class="badge badge-transfer px-3 py-2 rounded-pill fw-semibold fs-8">{{ $metode }}</span>
                                @else
                                    <span class="badge badge-qris px-3 py-2 rounded-pill fw-semibold fs-8">{{ $metode }}</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-warning">
                                Rp {{ number_format($item->total_harga ?? $item->total_pembayaran ?? $item->total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5" style="color: #a0aec0 !important;">
                                Belum ada data riwayat penjualan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($penjualan, 'links'))
            <div class="d-flex justify-content-end mt-4">
                <!-- {{ $penjualan->links() }} -->
            </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.penjualan-card-main');
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