@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
@include('layouts.navbar')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            📦 Detail Produk
        </h2>

        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0">{{ $produk->nama }}</h4>
        </div>

        <div class="card-body p-4">

            <div class="row align-items-center">

                <!-- Foto Produk -->
                <div class="col-lg-4 text-center mb-4 mb-lg-0">

                    @if($produk->foto)
                    <img src="{{ asset('storage/'.$produk->foto) }}"
                        class="img-fluid rounded-4 shadow"
                        style="max-height:320px; object-fit:cover;"
                        alt="{{ $produk->nama }}">
                    @else
                    <div class="border rounded-4 p-5 bg-light text-muted">
                        <h5>📷</h5>
                        <p class="mb-0">Foto tidak tersedia</p>
                    </div>
                    @endif

                </div>

                <!-- Informasi Produk -->
                <div class="col-lg-8">

                    <table class="table table-borderless align-middle">

                        <tr>
                            <th width="220" class="text-secondary">
                                Nama Produk
                            </th>
                            <td>
                                <span class="fw-bold fs-5">
                                    {{ $produk->nama }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-secondary">
                                Harga Beli
                            </th>
                            <td>
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                    Rp {{ number_format($produk->harga_beli,0,',','.') }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-secondary">
                                Harga Jual
                            </th>
                            <td>
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    Rp {{ number_format($produk->harga_jual,0,',','.') }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-secondary">
                                Stok
                            </th>
                            <td>

                                @if($produk->stok > 20)
                                <span class="badge bg-success fs-6">
                                    {{ $produk->stok }} pcs
                                </span>

                                @elseif($produk->stok > 5)
                                <span class="badge bg-warning text-dark fs-6">
                                    {{ $produk->stok }} pcs
                                </span>

                                @else
                                <span class="badge bg-danger fs-6">
                                    {{ $produk->stok }} pcs
                                </span>
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <th class="text-secondary">
                                Dibuat Oleh
                            </th>
                            <td>
                                👤 {{ $produk->user->name }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <div class="card-footer bg-white text-end py-3">

            <a href="{{ route('produk.edit', $produk) }}"
                class="btn btn-warning">
                ✏ Edit
            </a>

            <a href="{{ route('produk.index') }}"
                class="btn btn-secondary">
                Kembali
            </a>

        </div>

    </div>

</div>

@endsection