@extends('layouts.app')

@section('title', 'Tentang Saya')

@section('content')
<style>
    /* 1. Paksa hilangkan warna putih dari semua pembungkus luar layout */
    html, body, #app, main, 
    .main-content, .content-wrapper, .content, 
    .container, .container-fluid, .page-content,
    div[class*="content"], div[class*="wrapper"] {
        background-color: transparent !important;
        background-image: none !important;
    }

    /* 2. Pasang background cafe jika di body utama belum terpanggil */
    body {
        background: linear-gradient(rgba(10, 10, 12, 0.75), rgba(10, 10, 12, 0.85)), 
                    url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* 3. Card Utama Transparan Gelap (Persis Halaman Jenis) */
    .card-tentang-utama {
        background: rgba(22, 27, 34, 0.75) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
    }

    /* 4. Sub-box Isian Dalam (Transparan Gelap Tipis) */
    .card-tentang-inner {
        background: rgba(13, 17, 23, 0.5) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
    }
</style>

<div class="card card-tentang-utama text-white border-0 shadow-lg overflow-hidden">
    <div class="card-body p-4">
        
        <form action="{{ route('tentang.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <h2 class="fw-bold text-white mb-1">Tentang Saya</h2>
                    <p class="text-white-50 mb-0 small">Informasi profil, riwayat pendidikan, dan kontak pengembang sistem POS.</p>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            <!-- Tampilan Menumpuk Ke Bawah -->
            <div class="d-flex flex-column gap-4">
                
                <!-- 1. Foto Profil -->
                <div class="card-tentang-inner p-4 text-center">
                    <label class="form-label text-white-50 small fw-bold mb-3 d-block">FOTO PROFIL</label>
                    
                    <div class="d-flex flex-column align-items-center">
                        <div id="imagePreviewBox" 
                             onclick="document.getElementById('fotoInput').click()" 
                             class="d-flex flex-column align-items-center justify-content-center rounded-4 position-relative overflow-hidden mb-3" 
                             style="width: 150px; height: 150px; border: 2px solid #d4af37; background-color: rgba(0, 0, 0, 0.4); cursor: pointer; box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);">
                            
                            <img id="imagePreview" 
                                 src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('img/profil.jpg') }}" 
                                 alt="Foto Profil" 
                                 class="w-100 h-100 object-fit-cover {{ Auth::user()->foto || file_exists(public_path('img/profil.jpg')) ? '' : 'd-none' }}">

                            <div id="uploadPlaceholder" class="text-center p-2 {{ Auth::user()->foto || file_exists(public_path('img/profil.jpg')) ? 'd-none' : '' }}">
                                <div class="fs-2 text-warning">📷</div>
                                <small class="text-white-50 fw-semibold d-block">Klik Pilih Foto</small>
                            </div>
                        </div>

                        <input type="file" name="foto" id="fotoInput" accept="image/*" class="d-none" onchange="previewProfileImage(event)">
                        
                        <button type="button" 
                                onclick="document.getElementById('fotoInput').click()" 
                                class="btn btn-outline-warning btn-sm px-3 fw-semibold mb-3">
                            Pilih Gambar
                        </button>

                        <h4 class="fw-bold text-white mb-2">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h4>
                        <span class="badge bg-warning text-dark px-3 py-2 fw-semibold fs-7">
                            Web Developer / Student
                        </span>
                    </div>
                </div>

                <!-- 2. Tentang Saya -->
                <div class="card-tentang-inner p-4" style="border-left: 4px solid #d4af37 !important;">
                    <h5 class="fw-bold text-warning mb-2">📌 Tentang Saya</h5>
                    <p class="text-white-50 mb-0 leading-relaxed small">
                        Halo, saya {{ Auth::user()->name ?? 'Pengguna' }}. Saya tertarik pada dunia teknologi dan bisnis, khususnya dalam pengembangan serta penggunaan Point of Sale (POS). Menurut saya, POS bukan hanya alat untuk mencatat transaksi, tetapi juga solusi yang membantu bisnis mengelola penjualan, stok, dan laporan dengan lebih mudah dan efisien.
                    </p>
                </div>

                <!-- 3. Pendidikan & Kontak -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card-tentang-inner p-4 h-100" style="border-left: 4px solid #d4af37 !important;">
                            <h5 class="fw-bold text-warning mb-2">🎓 Pendidikan</h5>
                            <ul class="list-unstyled mb-0 text-white-50 small">
                                <li>
                                    <strong class="text-white">SMKN 4 TASIKMALAYA</strong><br>
                                    <span>Rekayasa Perangkat Lunak (RPL)</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-tentang-inner p-4 h-100" style="border-left: 4px solid #d4af37 !important;">
                            <h5 class="fw-bold text-warning mb-2">📞 Kontak</h5>
                            <ul class="list-unstyled mb-0 small text-white-50">
                                <li class="mb-2">
                                    <i class="bi bi-envelope-fill text-danger me-2"></i><strong class="text-white">Email:</strong> {{ Auth::user()->email ?? 'email@example.com' }}
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-whatsapp text-success me-2"></i><strong class="text-white">WhatsApp:</strong> 0812-3456-7890
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill text-primary me-2"></i><strong class="text-white">Lokasi:</strong> Jl. Bebedahan Kp. Gunung Salikur
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
    // Script JS untuk menghapus class background putih bawaan dari elemen induk secara otomatis
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.card-tentang-utama');
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

    function previewProfileImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('uploadPlaceholder');
                
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection