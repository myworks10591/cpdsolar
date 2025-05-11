@extends('adminlte::page')
@section('title', 'Create Dispatch')
@section('content_header')
    <h1>Create Dispatch</h1>
@stop

@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form action="{{ route('admin.dispatches.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Customer -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)

                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Dispatch Date -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dispatch_date">Dispatch Date</label>
                    <input type="datetime-local" name="dispatch_date" class="form-control" required>
                </div>
            </div>

            <!-- Driver Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="driver_name">Driver Name</label>
                    <input type="text" name="driver_name" class="form-control" required>
                </div>
            </div>

            <!-- Van Number -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="van_number">Van Number</label>
                    <input type="text" name="van_number" class="form-control" required>
                </div>
            </div>

            <!-- Driver Mobile -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="driver_mobile">Driver Mobile</label>
                    <input type="text" name="driver_mobile" class="form-control" required>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">Select Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Dispatched">Dispatched</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Remarks -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <!-- Products and Quantities -->
            <div class="col-md-12">
                <div class="form-group" id="products-container">
                    <label>Products</label>
                    <div id="product-fields">
                        <div class="row" id="product-1">
                            <div class="col-md-5">
                                <select style="margin: 8px" name="products[0][product_name]" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input style="margin: 8px" type="number" name="products[0][quantity]" class="form-control" placeholder="Quantity" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger" onclick="removeProduct('product-1')">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button style="margin: 8px" type="button" class="btn btn-primary" onclick="addProduct()">Add More</button>
            </div>

            <!-- Submit -->
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Create Dispatch</button>
                <a href="{{ route('admin.dispatches.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>

    <script>
        let productCount = 1;

        function addProduct() {
            const productField = `
                <div class="row" id="product-${productCount + 1}">
                    <div class="col-md-5">
                        <select style="margin: 8px" name="products[${productCount}][product_name]" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input style="margin: 8px" type="number" name="products[${productCount}][quantity]" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger" onclick="removeProduct('product-${productCount + 1}')">Remove</button>
                    </div>
                </div>
            `;
            document.getElementById('product-fields').insertAdjacentHTML('beforeend', productField);
            productCount++;
        }

        function removeProduct(id) {
            document.getElementById(id).remove();
        }
    </script>
@stop
