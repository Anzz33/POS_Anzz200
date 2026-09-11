@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

@include('layouts.navbar')

<h4 class="mb-3">Edit Produk</h4>

<form action="{{ route('produk.update', $produk) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('produk._form')

</form>

@endsection
