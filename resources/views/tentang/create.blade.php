@extends('layouts.app')

@section('title', 'Tambah Informasi Profil')

@section('content')
<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #b8860b !important;">
            Tambah Informasi Profil
        </h2>
        <p class="text-muted mb-0">
            Isi data perkenalan tentang saya, pendidikan, dan kontak.
        </p>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4 py-3" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
            <h4 class="mb-0 fw-bold">Form Biodata Pengembang</h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('tentang.store') }}" method="POST">
                @csrf

                <!-- Tentang Saya -->
                <div class="mb-4">
                    <label for="tentang_saya" class="form-label fw-semibold">
                        Tentang Saya <span class="text-danger">*</span>
                    </label>
                    <textarea name="tentang_saya" id="tentang_saya" rows="4" class="form-control @error('tentang_saya') is-invalid @enderror" placeholder="Tuliskan perkenalan singkat tentang diri kamu..." required>{{ old('tentang_saya') }}</textarea>
                    @error('tentang_saya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pendidikan -->
                <div class="mb-4">
                    <label for="pendidikan" class="form-label fw-semibold">
                        Pendidikan <span class="text-danger">*</span>
                    </label>
                    <textarea name="pendidikan" id="pendidikan" rows="4" class="form-control @error('pendidikan') is-invalid @enderror" placeholder="Contoh: &#10;- SMK Negeri 1 (2022 - Sekarang)&#10;- SMP Negeri 2 (2019 - 2022)" required>{{ old('pendidikan') }}</textarea>
                    @error('pendidikan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kontak -->
                <div class="mb-4">
                    <label for="kontak" class="form-label fw-semibold">
                        Kontak <span class="text-danger">*</span>
                    </label>
                    <textarea name="kontak" id="kontak" rows="4" class="form-control @error('kontak') is-invalid @enderror" placeholder="Contoh: &#10;Email: email@example.com&#10;No. HP / WA: 08123456789&#10;Alamat: Tasikmalaya, Jawa Barat" required>{{ old('kontak') }}</textarea>
                    @error('kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('tentang.index') }}" class="btn btn-outline-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection