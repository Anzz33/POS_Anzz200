@extends('layouts.app')

@section('title', 'Transaksi Penjualan Baru')

@section('content')
<style>
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

    .create-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    .penjualan-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    .produk-card {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px !important;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .produk-card:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: #d4af37 !important;
        transform: translateY(-2px);
    }

    .input-dark {
        background-color: rgba(15, 17, 23, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
    }

    .input-dark option {
        background-color: #161b22 !important;
        color: #ffffff !important;
    }

    .input-dark::placeholder {
        color: #a0aec0 !important;
    }

    .input-dark:focus {
        background-color: rgba(15, 17, 23, 0.95) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        color: #ffffff !important;
    }

    .table-transaksi {
        color: #ffffff !important;
        background: transparent !important;
    }

    .table-transaksi th {
        background-color: rgba(15, 17, 23, 0.8) !important;
        color: #a0aec0 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .table-transaksi td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
    }

    .style-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .style-scroll::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.2);
        border-radius: 4px;
    }
    .style-scroll::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
    }
</style>

<div class="row g-4">
    <!-- Kolom Kiri: Pilih Produk -->
    <div class="col-lg-7">
        <div class="card create-card-main h-100 border-0 shadow-lg">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-white m-0">Pilih Produk</h5>
                    <div style="width: 220px;">
                        <input type="text" id="searchProduk" class="form-control input-dark rounded-3 form-control-sm" placeholder="Cari produk...">
                    </div>
                </div>

                <div class="row g-3 overflow-auto style-scroll p-1" style="max-height: 520px;" id="produkContainer">
                    @forelse($produk as $item)
                        @php
                            $namaProduk = $item->nama ?? $item->nama_produk ?? 'Produk';
                            $hargaProduk = $item->harga_jual ?? $item->harga ?? 0;
                            $stokProduk = $item->stok ?? 0;
                        @endphp
                        <div class="col-md-4 col-6 produk-item" data-nama="{{ strtolower($namaProduk) }}">
                            <div class="card produk-card p-3 text-center h-100" 
                                 onclick="addToCart({{ $item->id }}, '{{ addslashes($namaProduk) }}', {{ $hargaProduk }}, {{ $stokProduk }})">
                                <div class="fw-bold text-white text-truncate">{{ $namaProduk }}</div>
                                <div class="small text-warning fw-semibold mt-1">Rp {{ number_format($hargaProduk, 0, ',', '.') }}</div>
                                <div class="small text-white-50 mt-1">Stok: {{ $stokProduk }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-white-50 my-auto">
                            <div class="mb-3">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            Belum ada produk yang tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Detail Transaksi -->
    <div class="col-lg-5">
        <form action="{{ route('penjualan.store') }}" method="POST" id="formTransaksi" onsubmit="return validateCheckout()">
            @csrf
            <div class="card create-card-main border-0 shadow-lg">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-white mb-3">Detail Transaksi</h5>

                    <!-- Input Pelanggan & Metode -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-white-50 mb-1">Nama Pelanggan</label>
                            <input type="text" name="pelanggan" class="form-control input-dark rounded-3" value="Pelanggan Umum" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-white-50 mb-1">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metodePembayaran" class="form-select input-dark rounded-3">
                                <option value="Tunai (Cash)">Tunai (Cash)</option>
                                <option value="Transfer">Transfer</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3 border border-secondary border-opacity-25 mb-3 style-scroll" style="min-height: 200px; max-height: 240px; overflow-y: auto;">
                        <table class="table table-transaksi align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th class="text-center" style="width: 100px;">QTY</th>
                                    <th class="text-end">SUBTOTAL</th>
                                    <th style="width: 30px;"></th>
                                </tr>
                            </thead>
                            <tbody id="cartTableBody">
                                <tr id="emptyCartRow">
                                    <td colspan="4" class="text-center py-5 text-white-50">
                                        <div class="mb-2">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="opacity-50">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                        </div>
                                        <div class="fw-semibold">Keranjang masih kosong.</div>
                                        <small class="opacity-75">Klik produk di sebelah kiri untuk menambahkan.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="penjualan-card-inner p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold text-white">Total Belanja:</span>
                            <span class="fs-4 fw-bold text-success" id="totalBelanjaText">Rp 0</span>
                            <input type="hidden" name="total_harga" id="totalHargaInput" value="0">
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small text-white-50 mb-1">Bayar (Rp)</label>
                                <input type="number" name="bayar" id="bayarInput" class="form-control input-dark rounded-3" value="0" min="0" oninput="calculateChange()">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-white-50 mb-1">Kembalian</label>
                                <div class="fw-bold text-white fs-6 py-2 px-3 rounded-3 input-dark" id="kembalianText">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary px-4 rounded-3 text-white border-secondary">Kembali</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100 rounded-3">Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal QRIS Pop-up -->
<div class="modal fade" id="qrisModal" tabindex="-1" aria-labelledby="qrisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content create-card-main text-white" style="background: rgba(22, 27, 34, 0.95) !important;">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold" id="qrisModalLabel">Pembayaran QRIS</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-2 text-white-50">Silakan scan kode QRIS di bawah ini:</p>
                <div class="bg-white p-3 d-inline-block rounded-3 my-2 shadow">
                    <img src="{{ asset('images/qris.png') }}" alt="QRIS Code" class="img-fluid" style="max-width: 240px;" onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=QRIS_DEMO';">
                </div>
                <div class="mt-2">
                    <span class="text-white-50 small">Total Pembayaran:</span>
                    <h4 class="fw-bold text-success mt-1" id="qrisTotalText">Rp 0</h4>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-warning text-dark fw-bold w-100 rounded-3" data-bs-dismiss="modal">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.create-card-main');
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

    // Perubahan metode pembayaran -> Tampilkan Modal QRIS
    document.getElementById('metodePembayaran')?.addEventListener('change', function() {
        if (this.value === 'QRIS') {
            let total = parseFloat(document.getElementById('totalHargaInput').value) || 0;
            
            if (total <= 0) {
                alert('Pilih produk terlebih dahulu!');
                this.value = 'Tunai (Cash)';
                return;
            }

            // Isi nilai nominal bayar sesuai total belanja secara otomatis
            document.getElementById('bayarInput').value = total;
            calculateChange();

            // Format teks nominal di modal QRIS
            document.getElementById('qrisTotalText').innerText = 'Rp ' + total.toLocaleString('id-ID');
            
            // Pop up Modal
            let qrisModal = new bootstrap.Modal(document.getElementById('qrisModal'));
            qrisModal.show();
        }
    });

    document.getElementById('searchProduk')?.addEventListener('keyup', function() {
        let query = this.value.toLowerCase();
        document.querySelectorAll('.produk-item').forEach(function(item) {
            let nama = item.getAttribute('data-nama');
            if (nama.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    function addToCart(id, nama, harga, stok) {
        let existing = cart.find(item => item.id === id);
        if (existing) {
            if (existing.qty < stok) {
                existing.qty++;
            } else {
                alert('Stok produk tidak mencukupi!');
                return;
            }
        } else {
            if (stok < 1) {
                alert('Stok produk habis!');
                return;
            }
            cart.push({ id: id, nama: nama, harga: harga, qty: 1, maxStok: stok });
        }
        renderCart();
    }

    function renderCart() {
        let tbody = document.getElementById('cartTableBody');
        tbody.innerHTML = '';

        if (cart.length === 0) {
            tbody.innerHTML = `
                <tr id="emptyCartRow">
                    <td colspan="4" class="text-center py-5 text-white-50">
                        <div class="mb-2">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="opacity-50">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <div class="fw-semibold">Keranjang masih kosong.</div>
                        <small class="opacity-75">Klik produk di sebelah kiri untuk menambahkan.</small>
                    </td>
                </tr>`;
            updateTotal(0);
            return;
        }

        let total = 0;
        cart.forEach((item, index) => {
            let subtotal = item.harga * item.qty;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td>
                        <div class="fw-semibold text-white text-truncate" style="max-width: 120px;">${item.nama}</div>
                        <input type="hidden" name="items[${index}][produk_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][qty]" class="form-control input-dark form-control-sm text-center rounded-2 p-1" 
                            value="${item.qty}" min="1" max="${item.maxStok}" onchange="updateQty(${item.id}, this.value)">
                    </td>
                    <td class="text-end text-warning fw-semibold">
                        Rp ${subtotal.toLocaleString('id-ID')}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeFromCart(${item.id})">&times;</button>
                    </td>
                </tr>`;
        });

        updateTotal(total);
    }

    function updateQty(id, qty) {
        let item = cart.find(i => i.id === id);
        if (item) {
            qty = parseInt(qty);
            if (qty > item.maxStok) {
                alert('Stok tidak mencukupi!');
                item.qty = item.maxStok;
            } else if (qty < 1 || isNaN(qty)) {
                item.qty = 1;
            } else {
                item.qty = qty;
            }
            renderCart();
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function updateTotal(total) {
        document.getElementById('totalBelanjaText').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalHargaInput').value = total;
        
        // Jika metode sedang QRIS saat total berubah, otomatis pas-kan nilai bayar
        if (document.getElementById('metodePembayaran').value === 'QRIS') {
            document.getElementById('bayarInput').value = total;
        }
        
        calculateChange();
    }

    function calculateChange() {
        let total = parseFloat(document.getElementById('totalHargaInput').value) || 0;
        let bayar = parseFloat(document.getElementById('bayarInput').value) || 0;
        let kembalian = bayar - total;

        let kembalianText = document.getElementById('kembalianText');
        if (kembalian >= 0) {
            kembalianText.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
            kembalianText.classList.remove('text-danger');
            kembalianText.classList.add('text-white');
        } else {
            kembalianText.innerText = '- Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
            kembalianText.classList.remove('text-white');
            kembalianText.classList.add('text-danger');
        }
    }

    function validateCheckout() {
        if (cart.length === 0) {
            alert('Keranjang belanja masih kosong! Silakan pilih produk terlebih dahulu.');
            return false;
        }

        let total = parseFloat(document.getElementById('totalHargaInput').value) || 0;
        let bayar = parseFloat(document.getElementById('bayarInput').value) || 0;

        if (bayar < total) {
            alert('Uang pembayaran kurang dari total belanja!');
            return false;
        }

        return true;
    }
</script>
@endsection