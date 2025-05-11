@extends('adminlte::page')
@section('title', 'Add Payment')

@section('content_header')
    <h1>Add Payment</h1>
@stop

<style>
    .select2-container--default .select2-selection--single {
        padding-bottom:28px !important;
    }


</style>

@section('content')
    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="customer_id">Customer (Mobile Number)</label>
            <select id="customer_id" name="customer_id" class="form-control" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" data-group-id="{{ $customer->group->name }}" data-total="{{ $customer->total_amount }}">
                        {{ $customer->name }} ({{ $customer->mobile_no }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="group_id">Group Name</label>
            <input type="text" name="group_id" id="group_id" class="form-control" readonly>    
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="received_amount">Received Amount</label>
            <input type="number" name="received_amount" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="payment_mode">Payment Mode</label>
            <select name="payment_mode" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="cheque">Cheque</option>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_received_date">Payment Received Date</label>
            <input type="date" name="payment_received_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Payment</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@stop

@section('js')
    {{-- Include Select2 CSS/JS from CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Activate Select2 on the customer dropdown
            $('#customer_id').select2({
                placeholder: '-- Select Customer --',
                allowClear: true,
                width: '100%'
            });

            // Populate group name and total amount
            $('#customer_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var groupId = selectedOption.data('group-id');
                var totalAmount = selectedOption.data('total');
                $('#group_id').val(groupId);
                $('#total_amount').val(totalAmount);
            });
        });
    </script>
@stop
