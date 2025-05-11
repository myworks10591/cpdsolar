@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <h1>Edit Customer</h1>
@stop

@section('content')
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="group_id">Group</label>
            <select name="group_id" id="group_id" class="form-control" required>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $group->id == $customer->group_id ? 'selected' : '' }}>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="district">District</label>
            <input type="text" name="district" id="district" class="form-control" value="{{ $customer->district }}" required>
        </div>

        <div class="form-group">
            <label for="name">Customer Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $customer->name }}" required>
        </div>

        <div class="form-group">
            <label for="mobile_no">Mobile Number</label>
            <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{ $customer->mobile_no }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $customer->email }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required>{{ $customer->address }}</textarea>
        </div>

        <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" name="pincode" id="pincode" class="form-control" value="{{ $customer->pincode }}" required>
        </div>

        <div class="form-group">
            <label for="electric_account_id">Electricity Account ID</label>
            <input type="text" name="electric_account_id" id="electric_account_id" class="form-control" value="{{ $customer->electric_account_id }}" required>
            @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="division">Division Name</label>
            <input type="text" name="division" id="division" class="form-control" value="{{ $customer->division }}" required>
        </div>

        <div class="form-group">
            <label for="kw">KW</label>
            <input type="number" step="0.01" name="kw" id="kw" class="form-control" value="{{ $customer->kw }}" required>
        </div>

        <div class="form-group">
            <label for="application_reference_no">Application Reference No</label>
            <input type="text" name="application_reference_no" id="application_reference_no" class="form-control" value="{{ $customer->application_reference_no }}" required>
        </div>

        <div class="form-group">
            <label for="registration_date">Registration Date</label>
            <input type="date" name="registration_date" id="registration_date" class="form-control" value="{{ $customer->registration_date }}" required>
        </div>


        <div class="form-group">
            <label for="payment_mode">Jan Samarth / Cash/Ecofy</label>
            <input type="text" name="payment_mode" id="payment_mode" class="form-control" value="{{ $customer->payment_mode }}" required>
        </div>

        
        <div class="form-group">
            <label for="account_no">Account Number</label>
            <input type="text" name="account_no" id="account_no" class="form-control" value="{{ $customer->account_no }}" required>
        </div>
        <div class="form-group">
            <label for="jan_samarth_bank_name">Jan Samarth Bank Name</label>
            <input type="text" name="jan_samarth_bank_name" id="jan_samarth_bank_name" class="form-control" value="{{ $customer->jan_samarth_bank_name }}" required>
        </div>


        <div class="form-group">
            <label for="jan_samarth_bank_branch">Jan Samarth Bank Branch</label>
            <input type="text" name="jan_samarth_bank_branch" id="jan_samarth_bank_branch" class="form-control" value="{{ $customer->jan_samarth_bank_branch }}" required>
        </div>

        <div class="form-group">
            <label for="jan_samarth_ifsc_code">Jan Samarth IFSC Code</label>
            <input type="text" name="jan_samarth_ifsc_code" id="jan_samarth_ifsc_code" class="form-control" value="{{ $customer->jan_samarth_ifsc_code }}" required>
        </div>

        
        <div class="form-group">
            <label for="jan_samarth_date">Jan Samarth Date</label>
            <input type="date" name="jan_samarth_date" id="jan_samarth_date" class="form-control" value="{{ $customer->jan_samarth_date }}" required>
        </div>

        <div class="form-group">
            <label for="document_submission_date">Document Submission Date</label>
            <input type="date" name="document_submission_date" id="document_submission_date" class="form-control" value="{{ $customer->document_submission_date }}" required>
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ $customer->total_amount }}" required>
        </div>
        
        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ $customer->remarks }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
@stop
