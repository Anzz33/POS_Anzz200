@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
@include('layouts.navbar')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-receipt"></i> Detail Penjualan
        </h2>

        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Transaksi</h5>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="text-muted">Tanggal Transaksi</label>
                    <h6>{{ $penjualan->created_at->translatedFormat('d F Y, H:i') }}</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted">Kasir</label>
                    <h6>{{ $penjualan->user->name }}</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted">Metode Pembayaran</label>
                    <h6>
                        @if($penjualan->metode_pembayaran == 'CASH')
                        <span class="badge bg-success">CASH</span>
                        @else
                        <span class="badge bg-info">
                            {{ $penjualan->metode_pembayaran }}
                        </span>
                        @endif
                    </h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted">Status</label>

                    @if($penjualan->status == 'COMPLETED')
                    <h6><span class="badge bg-success">COMPLETED</span></h6>
                    @elseif($penjualan->status == 'OPEN')
                    <h6><span class="badge bg-warning text-dark">OPEN</span></h6>
                    @else
                    <h6><span class="badge bg-secondary">{{ $penjualan->status }}</span></h6>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <h5 class="mb-0">Daftar Produk</h5>

            <h5 class="mb-0">
                Total :
                <span class="badge bg-success fs-6">
                    Rp {{ number_format($penjualan->total_pembayaran,0,',','.') }}
                </span>
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th class="text-start">Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($penjualan->itemPenjualan as $index => $item)

                        <tr>

                            <td class="text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="fw-semibold">
                                {{ $item->produk->nama }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($item->produk->harga,0,',','.') }}
                            </td>

                            <td class="text-center">
                                {{ $item->jumlah }}
                            </td>

                            <td class="text-end fw-bold">
                                Rp {{ number_format($item->subtotal,0,',','.') }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada produk pada transaksi ini.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection