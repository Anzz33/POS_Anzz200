@extends('layouts.app')

@section('title', 'POS')

@section('content')

<div class="container mt-4">

    @if(session('error'))
    <div class="alert alert-danger shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #b8860b !important;">
            🛒 Point Of Sale (POS)
        </h2>

        <p class="text-muted mb-0">
            Tambahkan produk ke keranjang dan lakukan transaksi penjualan.
        </p>
    </div>

    <div class="row">

        <!-- ================= DAFTAR PRODUK ================= -->
        <div class="col-lg-6 mb-3">

            <div class="card shadow border-0">

                <div class="card-header text-white" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
                    <h5 class="mb-0 fw-bold">
                        📦 Daftar Produk
                    </h5>
                </div>

                <div class="card-body" style="max-height:70vh; overflow-y:auto;">

                    <form method="GET" action="{{ route('penjualan.create') }}" class="mb-3">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Cari produk..."
                                onkeyup="this.form.submit()">

                            <button class="btn text-white" style="background-color: #b8860b !important;" type="submit">
                                Cari
                            </button>
                        </div>
                    </form>

                    @foreach($products as $product)
                    <form method="POST" action="{{ route('itempenjualan.store') }}" class="mb-2">
                        @csrf
                        <!-- INPUT PENJUALAN ID & PRODUCT ID (WAJIB ADA) -->
                        <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="card border">
                            <div class="card-body p-2">
                                <div class="row align-items-center">

                                    <div class="col-2">
                                        <img
                                            src="{{ asset('storage/'.$product->foto) }}"
                                            class="rounded-circle shadow"
                                            style="width:50px; height:50px; object-fit:cover;">
                                    </div>

                                    <div class="col-5">
                                        <h6 class="mb-1 text-truncate">
                                            {{ $product->nama }}
                                        </h6>
                                        <small class="fw-bold" style="color: #b8860b !important;">
                                            Rp {{ number_format($product->harga_jual) }}
                                        </small>
                                    </div>

                                    <div class="col-3">
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="1"
                                            min="1"
                                            class="form-control form-control-sm {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}">
                                    </div>

                                    <div class="col-2">
                                        <button
                                            type="submit"
                                            class="btn btn-sm text-white fw-bold w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"
                                            style="background-color: #b8860b !important;">
                                            +
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- ================= KERANJANG ================= -->
        <div class="col-lg-6 mb-3">

            <div class="card shadow border-0">

                <div class="card-header text-white" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
                    <h5 class="mb-0 fw-bold">
                        🛒 Keranjang Belanja
                    </h5>
                </div>

                <div class="table-responsive" style="max-height: 45vh; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sale->itemPenjualan as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td class="fw-bold" style="color: #b8860b !important;">
                                    Rp {{ number_format($item->produk->harga_jual) }}
                                </td>
                                <td width="90">
                                    <form method="POST" action="{{ route('itempenjualan.update',$item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->kuantitas }}"
                                            class="form-control form-control-sm"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>

                                <td>
                                    Rp {{ number_format($item->subtotal) }}
                                </td>

                                <td>
                                    @can('delete',$item)
                                    <form method="POST" action="{{ route('itempenjualan.destroy',$item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada item di keranjang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total</h5>
                        <h4 class="fw-bold" style="color: #b8860b !important;">
                            Rp {{ number_format($sale->itemPenjualan->sum('subtotal')) }}
                        </h4>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('penjualan.update',$sale->id) }}"
                        onsubmit="return confirm('Yakin ingin checkout?')">
                        @csrf
                        @method('PUT')

                        <select name="payment_method" class="form-select mb-3" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="CASH">Cash</option>
                            <option value="QRIS">QRIS</option>
                        </select>

                        <button
                            class="btn text-white w-100 fw-bold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"
                            style="background-color: #28a745 !important;">
                            ✅ Checkout
                        </button>
                    </form>

                    @can('delete',$sale)
                    <form
                        method="POST"
                        action="{{ route('penjualan.destroy',$sale->id) }}"
                        onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            ❌ Batalkan Transaksi
                        </button>
                    </form>
                    @endcan
                </div>

            </div>

        </div>

    </div>

</div>

@endsection