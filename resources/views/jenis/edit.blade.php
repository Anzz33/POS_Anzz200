@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Jenis Barang</h5>
                    <a href="{{ route('jenis.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('jenis.update', $jenis->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_jenis" class="form-label">Nama Jenis <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_jenis') is-invalid @enderror" 
                                   id="nama_jenis" 
                                   name="nama_jenis" 
                                   value="{{ old('nama_jenis', $jenis->nama_jenis) }}" 
                                   required>
                            @error('nama_jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi / Keterangan</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3">{{ old('deskripsi', $jenis->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jenis.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection