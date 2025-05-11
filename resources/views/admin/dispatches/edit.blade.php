@extends('adminlte::page')

@section('title', 'Edit Dispatch')

@section('content_header')
    <h1>Edit Dispatch</h1>
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
    <form action="{{ route('admin.dispatches.update', $dispatch->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Customer -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                {{ $customer->id == $dispatch->customer_id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Dispatch Date -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dispatch_date">Dispatch Date</label>
                    
                    <input type="datetime-local" name="dispatch_date" class="form-control" value="{{ $dispatch->dispatch_date ? $dispatch->dispatch_date : '' }}" required>

                </div>
            </div>

            <!-- Driver Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="driver_name">Driver Name</label>
                    <input type="text" name="driver_name" class="form-control" value="{{ $dispatch->driver_name }}" required>
                </div>
            </div>

            <!-- Van Number -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="van_number">Van Number</label>
                    <input type="text" name="van_number" class="form-control" value="{{ $dispatch->van_number }}" required>
                </div>
            </div>

            <!-- Driver Mobile -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="driver_mobile">Driver Mobile</label>
                    <input type="text" name="driver_mobile" class="form-control" value="{{ $dispatch->driver_mobile }}" required>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">Select Status</option>
                        <option value="Pending" {{ $dispatch->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Dispatched" {{ $dispatch->status == 'Dispatched' ? 'selected' : '' }}>Dispatched</option>
                        <option value="Delivered" {{ $dispatch->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ $dispatch->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Remarks -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3">{{ $dispatch->remarks }}</textarea>
                </div>
            </div>

            <!-- Products and Quantities -->
            <div class="col-md-12">
                <div class="form-group" id="products-container">
                    <label>Products</label>
                    <div id="product-fields">
                        @foreach($dispatch->products as $index => $product)
                            <div class="row" id="product-{{ $index + 1 }}">
                                <div class="col-md-5">
                                    <select style="margin: 8px" name="products[{{ $index }}][product_name]" class="form-control" required>
                                        <option value="">Select Product</option>
                                        @foreach($productsArr as $productsRes)
                                            <option value="{{ $productsRes->id }}" 
                                                {{ $productsRes->id == $product->product_name ? 'selected' : '' }}
                                                >
                                                {{ $productsRes->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input style="margin: 8px" type="number" name="products[{{ $index }}][quantity]" class="form-control" placeholder="Quantity" value="{{ $product->quantity }}" required>
                                </div>
                                <div class="col-md-2">
                                    <button style="margin: 8px" type="button" class="btn btn-danger" onclick="removeProduct('product-{{ $index + 1 }}')">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addProduct()">Add More</button>
            </div>

            <!-- Submit -->
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Update Dispatch</button>
                <a href="{{ route('admin.dispatches.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>

    <script>
        let productCount = {{ count($dispatch->products) }};

        function addProduct() {
            const productField = `
                <div class="row" id="product-${productCount + 1}">
                    <div class="col-md-5">
                        <select style="margin: 8px" name="products[${productCount}][product_name]" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach($productsArr as $product)
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
