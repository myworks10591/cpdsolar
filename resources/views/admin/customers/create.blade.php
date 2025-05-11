@extends('adminlte::page')

@section('title', 'Create Customer')

@section('content_header')
    <h1>Create New Customer</h1>
@stop

@section('content')
<style>
    .select2-container--default .select2-selection--single {
        padding-bottom: 28px !important;
    }
</style>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf

       

        <div class="form-group">
            <label for="group_id">Group</label>
            <!-- <select name="group_id" id="group_id" class="form-control" required> -->
            <select name="group_id" id="group_id" class="form-control select2" required>
                <option value="">Select Group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="district">District</label>
            <input type="text" name="district" id="district" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="name">Customer Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="mobile_no">Mobile Number</label>
            <input type="text" name="mobile_no" id="mobile_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" name="pincode" id="pincode" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="electric_account_id">Electricity Account ID</label>
            <input type="text" name="electric_account_id" id="electric_account_id" class="form-control" required>
            @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="division">Division Name</label>
            <input type="text" name="division" id="division" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="kw">KW</label>
            <input type="number" step="0.01" name="kw" id="kw" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="application_reference_no">Application Reference No</label>
            <input type="text" name="application_reference_no" id="application_reference_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="registration_date">Registration Date</label>
            <input type="date" name="registration_date" id="registration_date" class="form-control" required>
        </div>
        
         <div class="form-group">
            <label for="payment_mode">Jan Samarth /Cash/Ecofy</label>
            <input type="text" name="payment_mode" id="payment_mode" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="account_no">Account Number</label>
            <input type="text" name="account_no" id="account_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jan_samarth_bank_name">Jan Samarth Bank Name</label>
            <input type="text" name="jan_samarth_bank_name" id="jan_samarth_bank_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jan_samarth_bank_branch">Jan Samarth Bank Branch</label>
            <input type="text" name="jan_samarth_bank_branch" id="jan_samarth_bank_branch" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jan_samarth_ifsc_code">Jan Samarth IFSC Code</label>
            <input type="text" name="jan_samarth_ifsc_code" id="jan_samarth_ifsc_code" class="form-control" required>
        </div>
    
       

        <div class="form-group">
            <label for="jan_samarth_date">Jan Samarth Date</label>
            <input type="date" name="jan_samarth_date" id="jan_samarth_date" class="form-control">
        </div>

        <div class="form-group">
            <label for="document_submission_date">Document Submission Date</label>
            <input type="date" name="document_submission_date" id="document_submission_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="modal_no">Modal Number</label>
            <select name="modal_no" id="modal_no" class="form-control" required>
                <option value="">Select Modal Number</option>
                @foreach($modalNumbers as $id => $modalNumber)
                    <option value="{{ $id }}">{{ $modalNumber }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Customer</button>
    </form>
    
@stop
@section('js')
    {{-- Include Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Apply Select2 to the group dropdown
            $('#group_id').select2({
                placeholder: '-- Select Group --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@stop