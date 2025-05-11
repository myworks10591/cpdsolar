@extends('adminlte::page')
@section('title', 'Edit Payment')

@section('content_header')
    <h1>Edit Payment</h1>
@stop

@section('content')
    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="customer_id">Customer (Mobile Number)</label>
            <select name="customer_id" class="form-control">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customer->id == $payment->customer_id ? 'selected' : '' }}>
                        {{ $customer->name }} ({{ $customer->mobile_no }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="group_id">Group Name</label>
            <input type="text" name="group_id" id="group_id" class="form-control" value="{{ $payment->customer->group->name }}" readonly>    
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" class="form-control" step="0.01" value="{{ $payment->customer->total_amount }}" readonly>
        </div>

        <div class="form-group">
            <label for="received_amount">Received Amount</label>
            <input type="number" name="received_amount" class="form-control" step="0.01" value="{{ $payment->received_amount }}" required>
        </div>

        <div class="form-group">
            <label for="payment_mode">Payment Mode</label>
            <select name="payment_mode" class="form-control">
                <option value="cash" {{ $payment->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="bank_transfer" {{ $payment->payment_mode == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="cheque" {{ $payment->payment_mode == 'cheque' ? 'selected' : '' }}>Cheque</option>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_received_date">Payment Received Date</label>
            <input type="date" name="payment_received_date" class="form-control" value="{{ $payment->payment_received_date }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Payment</button>
    </form>
@stop
