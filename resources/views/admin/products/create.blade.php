<!-- resources/views/admin/products/create.blade.php -->
@extends('adminlte::page')
@section('title', 'Create Product')
@section('content')
    <h1>Create Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Qnty</label>
            <input type="number" name="Qnty" id="Qnty" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection
