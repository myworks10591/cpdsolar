<!-- resources/views/admin/products/edit.blade.php -->
@extends('adminlte::page')
@section('title', 'Edit Product')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Qnty</label>
            <input type="number" name="Qnty" id="Qnty" class="form-control" value="{{ $product->Qnty }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
