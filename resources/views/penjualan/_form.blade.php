<div class="row g-3">

    <!-- KOLOM KIRI: Katalog & Pencarian Produk -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="fw-bold mb-0 text-dark">Pilih Produk</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">🔍</span>
                            <input type="text" id="searchProduct" class="form-control bg-light border-start-0" placeholder="Cari nama produk...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body overflow-auto" style="max-height: 650px;">
                <div class="row row-cols-2 row-cols-md-3 g-3" id="productGrid">
                    @forelse($products as $product)
                    <div class="col product-item" data-name="{{ strtolower($product->nama ?? $product->name) }}">
                        <div class="card h-100 border shadow-sm rounded-3 overflow-hidden product-card" 
                             onclick="addToCart({{ $product->id }}, '{{ addslashes($product->nama ?? $product->name) }}', {{ $product->harga_jual ?? $product->selling_price }}, {{ $product->stok }})"
                             style="cursor: pointer; transition: transform 0.2s;">
                            
                            <div class="position-relative bg-light text-center py-2" style="height: 120px;">
                                @if(!empty($product->foto))
                                    <img src="{{ asset('storage/' . $product->foto) }}" class="h-100 object-fit-cover rounded" alt="{{ $product->nama ?? $product->name }}">
                                @else
                                    <div class="h-100 d-flex align-items-center justify-content-center text-muted fw-bold">No Image</div>
                                @endif
                                <span class="position-absolute top-0 end-0 badge bg-dark m-2">Stok: {{ $product->stok }}</span>
                            </div>

                            <div class="card-body p-2 d-flex flex-column justify-content-between">
                                <h6 class="card-title fw-bold text-truncate mb-1 small">{{ $product->nama ?? $product->name }}</h6>
                                <span class="text-warning-emphasis fw-bold">Rp {{ number_format($product->harga_jual ?? $product->selling_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 text-muted">
                        Tidak ada produk tersedia
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: Detail Keranjang & Kasir -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header text-white rounded-top-4 py-3" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
                <h5 class="mb-0 fw-bold">Detail Transaksi</h5>
            </div>

            <div class="card-body p-3">
                <!-- Informasi Pelanggan & Metode Pembayaran -->
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Pelanggan</label>
                        <input type="text" name="pelanggan_nama" class="form-control form-control-sm" value="Pelanggan Umum" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select form-select-sm" required>
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel Keranjang -->
                <div class="table-responsive mb-3" style="max-height: 250px;">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th style="width: 90px;">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th style="width: 30px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <tr id="emptyCartRow">
                                <td colspan="4" class="text-center text-muted py-4 small">
                                    Keranjang masih kosong.<br>Klik produk di sebelah kiri untuk menambahkan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Total Belanja:</span>
                        <span class="fw-bold fs-5 text-success" id="totalDisplay">Rp 0</span>
                        <input type="hidden" name="total_harga" id="totalInput" value="0">
                    </div>

                    <div class="row g-2 pt-2 border-top">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Bayar (Rp)</label>
                            <input type="number" id="bayarInput" class="form-control form-control-sm" min="0" placeholder="0" oninput="calculateChange()">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kembalian</label>
                            <input type="text" id="kembalianDisplay" class="form-control form-control-sm bg-white" readonly value="Rp 0">
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mb-3">
                    <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Catatan transaksi (opsional)"></textarea>
                </div>

                <!-- Hidden Inputs Container untuk Form Submit -->
                <div id="hiddenCartInputs"></div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary w-50">Kembali</a>
                    <button type="submit" id="btnSubmit" class="btn btn-warning text-dark fw-bold w-50" disabled>Simpan Transaksi</button>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    .product-card:hover {
        transform: translateY(-3px);
        border-color: #b8860b !important;
    }
</style>

<script>
    let cart = [];

    function addToCart(id, name, price, maxStock) {
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            if (existingItem.qty < maxStock) {
                existingItem.qty++;
            } else {
                alert('Stok produk telah mencapai batas maksimal!');
                return;
            }
        } else {
            cart.push({ id, name, price, maxStock, qty: 1 });
        }
        renderCart();
    }

    function updateQty(id, delta) {
        let item = cart.find(i => i.id === id);
        if (!item) return;

        item.qty += delta;

        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        } else if (item.qty > item.maxStock) {
            alert('Stok produk telah mencapai batas maksimal!');
            item.qty = item.maxStock;
        }

        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function renderCart() {
        const tbody = document.getElementById('cartTableBody');
        const hiddenInputs = document.getElementById('hiddenCartInputs');
        tbody.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (cart.length === 0) {
            tbody.innerHTML = `
                <tr id="emptyCartRow">
                    <td colspan="4" class="text-center text-muted py-4 small">
                        Keranjang masih kosong.<br>Klik produk di sebelah kiri untuk menambahkan.
                    </td>
                </tr>`;
            document.getElementById('totalDisplay').innerText = 'Rp 0';
            document.getElementById('totalInput').value = 0;
            document.getElementById('btnSubmit').disabled = true;
            calculateChange();
            return;
        }

        let total = 0;

        cart.forEach((item, index) => {
            let subtotal = item.price * item.qty;
            total += subtotal;

            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <div class="fw-bold small">${item.name}</div>
                    <div class="text-muted extra-small">Rp ${item.price.toLocaleString('id-ID')}</div>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary px-1" type="button" onclick="updateQty(${item.id}, -1)">-</button>
                        <input type="text" class="form-control text-center px-0" value="${item.qty}" readonly>
                        <button class="btn btn-outline-secondary px-1" type="button" onclick="updateQty(${item.id}, 1)">+</button>
                    </div>
                </td>
                <td class="text-end fw-semibold small">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button type="button" class="btn btn-link text-danger p-0" onclick="removeFromCart(${item.id})">×</button>
                </td>
            `;
            tbody.appendChild(tr);

            hiddenInputs.innerHTML += `
                <input type="hidden" name="items[${index}][produk_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
                <input type="hidden" name="items[${index}][harga]" value="${item.price}">
                <input type="hidden" name="items[${index}][subtotal]" value="${subtotal}">
            `;
        });

        document.getElementById('totalDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalInput').value = total;
        document.getElementById('btnSubmit').disabled = false;
        calculateChange();
    }

    function calculateChange() {
        const total = parseFloat(document.getElementById('totalInput').value) || 0;
        const bayar = parseFloat(document.getElementById('bayarInput').value) || 0;
        const kembalian = bayar - total;

        const kembalianDisplay = document.getElementById('kembalianDisplay');

        if (bayar >= total && total > 0) {
            kembalianDisplay.value = 'Rp ' + kembalian.toLocaleString('id-ID');
            kembalianDisplay.classList.remove('text-danger');
            kembalianDisplay.classList.add('text-success');
        } else {
            kembalianDisplay.value = 'Rp 0';
            kembalianDisplay.classList.remove('text-success');
        }
    }

    document.getElementById('searchProduct').addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(keyword) ? 'block' : 'none';
        });
    });
</script>