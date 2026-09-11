@csrf

<div class="card shadow-lg border-0 rounded-4">

    <div class="card-header text-white rounded-top-4 py-3" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
        <h4 class="mb-0 fw-bold">
            Form Produk
        </h4>
    </div>

    <div class="card-body p-4">

        <div class="row">

            <!-- Bingkai Foto Produk -->
            <div class="col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">

                        <h6 class="fw-bold mb-3">Foto Produk</h6>

                        <!-- Area Bingkai Photo Box -->
                        <div class="border border-2 border-secondary border-dashed rounded-4 p-2 d-flex align-items-center justify-content-center bg-light position-relative shadow-sm mb-3"
                             style="width: 200px; height: 200px; cursor: pointer; overflow: hidden;"
                             onclick="document.getElementById('fotoInput').click();">

                            @php
                                $hasExistingPhoto = !empty($produk->foto);
                            @endphp

                            <!-- Foto Lama / Foto Preview -->
                            <img id="preview"
                                 src="{{ $hasExistingPhoto ? asset('storage/' . $produk->foto) : '#' }}"
                                 alt="Preview Foto"
                                 class="w-100 h-100 rounded-3 {{ $hasExistingPhoto ? '' : 'd-none' }}"
                                 style="object-fit: cover;">

                            <!-- Placeholder Kosong (Ikon Kamera) -->
                            <div id="placeholderText" class="text-center text-muted {{ $hasExistingPhoto ? 'd-none' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-camera mb-2 opacity-50" viewBox="0 0 16 16">
                                    <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                    <path d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7z"/>
                                </svg>
                                <span class="d-block small fw-semibold">Klik untuk Pilih Foto</span>
                            </div>

                        </div>

                        <!-- Input File (Hidden) -->
                        <input type="file"
                               name="foto"
                               id="fotoInput"
                               onchange="previewImage(this)"
                               class="d-none @error('foto') is-invalid @enderror"
                               accept="image/*">

                        <button type="button" class="btn btn-sm btn-outline-warning fw-semibold px-3" onclick="document.getElementById('fotoInput').click();">
                            Pilih Gambar
                        </button>

                        @error('foto')
                        <div class="invalid-feedback d-block mt-2">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>
            </div>

            <!-- Form Inputs -->
            <div class="col-lg-8">

                <div class="row">

                    <!-- Nama Produk -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Produk
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $produk->nama ?? '') }}"
                               placeholder="Masukkan nama produk">

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Jenis Produk -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Jenis Produk
                        </label>

                        <select name="jenis_id"
                                class="form-select @error('jenis_id') is-invalid @enderror">
                            <option value="">Pilih Jenis Produk</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item->id }}" {{ old('jenis_id', $produk->jenis_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_jenis }}
                                </option>
                            @endforeach
                        </select>

                        @error('jenis_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Harga Beli -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Harga Beli
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number"
                                   name="purchase_price"
                                   class="form-control @error('purchase_price') is-invalid @enderror"
                                   value="{{ old('purchase_price', $produk->harga_beli ?? '') }}"
                                   placeholder="0">
                        </div>

                        @error('purchase_price')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Harga Jual
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number"
                                   name="selling_price"
                                   class="form-control @error('selling_price') is-invalid @enderror"
                                   value="{{ old('selling_price', $produk->harga_jual ?? '') }}"
                                   placeholder="0">
                        </div>

                        @error('selling_price')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Jumlah Stok -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Jumlah Stok
                        </label>

                        <input type="number"
                               name="stok"
                               class="form-control @error('stok') is-invalid @enderror"
                               value="{{ old('stok', $produk->stok ?? '') }}"
                               placeholder="Masukkan jumlah stok">

                        @error('stok')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card-footer bg-light d-flex justify-content-end gap-2 py-3">
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>

        <button type="submit" class="btn btn-success">
            Simpan Produk
        </button>
    </div>

</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholderText');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        }
    }
</script>