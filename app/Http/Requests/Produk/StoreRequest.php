<?php

namespace App\Http\Requests\Produk;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Mendukung nama input dalam bahasa Indonesia maupun Inggris
            'jenis_id'        => 'nullable|exists:jenis,id',
            'jenis_produk_id' => 'nullable|exists:jenis,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama'            => 'required_without_all:name,nama_produk|nullable|string|max:255',
            'nama_produk'     => 'nullable|string|max:255',
            'name'            => 'nullable|string|max:255',
            'harga_beli'      => 'required_without:purchase_price|nullable|numeric|min:0',
            'purchase_price'  => 'nullable|numeric|min:0',
            'harga_jual'      => 'required_without:selling_price|nullable|numeric|min:0',
            'selling_price'   => 'nullable|numeric|min:0',
            'stok'            => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_id.exists'           => 'Jenis produk tidak valid.',
            'jenis_produk_id.exists'    => 'Jenis produk tidak valid.',
            'foto.image'                => 'File yang diupload harus gambar.',
            'foto.mimes'                => 'Ekstensi gambar harus JPG, JPEG, PNG.',
            'foto.max'                  => 'Maksimal ukuran gambar 2MB.',
            'nama.required_without_all' => 'Nama produk wajib diisi.',
            'harga_beli.required_without' => 'Harga beli wajib diisi.',
            'harga_jual.required_without' => 'Harga jual wajib diisi.',
            'stok.required'             => 'Stok wajib diisi.',
            'stok.integer'              => 'Stok harus diisi angka.',
        ];
    }
}