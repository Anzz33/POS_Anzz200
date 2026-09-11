@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<style>
    /* Hilangkan background pembungkus bawaan */
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

    /* Card Utama Glassmorphism */
    .create-card-main {
        background: rgba(30, 34, 42, 0.85) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        color: #ffffff !important;
    }

    /* Sub Card Form */
    .create-card-inner {
        background: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }

    /* Form Input & Select */
    .input-dark {
        background-color: rgba(15, 17, 23, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
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
        background-color: rgba(15, 17, 23, 0.8) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        color: #ffffff !important;
    }

    /* Upload Box Foto */
    .upload-box {
        border: 1px dashed rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        background: rgba(15, 17, 23, 0.4);
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .upload-box:hover {
        border-color: #d4af37;
        background: rgba(255, 255, 255, 0.05);
    }

    .img-preview {
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
    }
</style>

<div class="card create-card-main border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <!-- Header Atas -->
        <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <h2 class="fw-bold text-white mb-1">Tambah Produk</h2>
            <p class="mb-0 small" style="color: #a0aec0 !important;">Tambahkan data produk baru ke dalam sistem POS.</p>
        </div>

        <!-- Alert Notifikasi Error Validasi -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 text-white mb-4" style="background-color: rgba(220, 53, 69, 0.85); backdrop-filter: blur(5px);" role="alert">
                <div class="fw-bold mb-1">Gagal Menyimpan Data:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Inner Form Card -->
            <div class="create-card-inner p-4 mb-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge bg-warning p-1 rounded-1"></span>
                    <h6 class="fw-bold text-white m-0">Form Produk</h6>
                </div>

                <div class="row g-4">
                    <!-- Upload Foto Produk -->
                    <div class="col-lg-4">
                        <label class="form-label small text-white-50 mb-2">Foto Produk</label>
                        <div class="upload-box p-3 text-center" onclick="document.getElementById('fotoInput').click()">
                            <div id="uploadPlaceholder" class="text-white-50">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mb-2 opacity-75">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <div class="small fw-semibold text-white">Klik untuk Pilih Foto</div>
                            </div>
                            <img id="imagePreview" class="img-preview d-none w-100" alt="Preview">
                        </div>
                        <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(event)">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2 text-white border-secondary" onclick="document.getElementById('fotoInput').click()">
                            Pilih Gambar
                        </button>
                    </div>

                    <!-- Detail Input Form -->
                    <div class="col-lg-8">
                        <div class="row g-3">
                            <!-- Nama Produk & Jenis Produk -->
                            <div class="col-md-6">
                                <label class="form-label small text-white-50 mb-1">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control input-dark rounded-3" placeholder="Masukkan nama produk" value="{{ old('nama') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-white-50 mb-1">Jenis Produk <span class="text-danger">*</span></label>
                                <select name="jenis_id" class="form-select input-dark rounded-3" required>
                                    <option value="" disabled {{ old('jenis_id') ? '' : 'selected' }}>Pilih Jenis Produk</option>
                                    @if(isset($jenis))
                                        @foreach($jenis as $j)
                                            <option value="{{ $j->id }}" {{ old('jenis_id') == $j->id ? 'selected' : '' }}>
                                                {{ $j->nama_jenis ?? $j->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Harga Beli & Harga Jual -->
                            <div class="col-md-6">
                                <label class="form-label small text-white-50 mb-1">Harga Beli <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text input-dark border-end-0 text-white-50">Rp</span>
                                    <input type="number" name="harga_beli" class="form-control input-dark rounded-end-3 border-start-0" value="{{ old('harga_beli', 0) }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-white-50 mb-1">Harga Jual <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text input-dark border-end-0 text-white-50">Rp</span>
                                    <input type="number" name="harga_jual" class="form-control input-dark rounded-end-3 border-start-0" value="{{ old('harga_jual', 0) }}" min="0" required>
                                </div>
                            </div>

                            <!-- Jumlah Stok -->
                            <div class="col-md-12">
                                <label class="form-label small text-white-50 mb-1">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control input-dark rounded-3" value="{{ old('stok', 0) }}" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary px-4 rounded-3 text-white border-secondary">
                    &larr; Kembali
                </a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 rounded-3">
                    Simpan Produk
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            output.src = reader.result;
            output.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

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
</script>
@endsection