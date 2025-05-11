@extends('adminlte::page')

@section('title', 'Edit Customer Status')

@section('content_header')
    <h1>Edit Customer Status</h1>
    
@stop

@section('content')
        <div class="card-body">
            <form action="{{ route('admin.customer_statuses.update', $customerStatus->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="group_id">Group Name</label>
                    <select name="group_id" id="group_id" class="form-control" required disabled>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ $customerStatus->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_id">Customer Name</label>
                    <select name="customer_id" id="customer_id" class="form-control" required disabled>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customerStatus->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
               
                <div class="form-group">
                
                    <label for="invoice_no">Invoice No.</label>
                
                    <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ $customerStatus->invoice_no }}" required>
                    @if(session('error'))
                    <p style="color:red">{{ session('error') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="invoice_date">Invoice date</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $customerStatus->invoice_date }}" required>
                </div>
                <!-- <div class="form-group">
                    <label for="commision">Commission</label>
                    <input type="text" name="commision" id="commision" class="form-control" value="{{ $customerStatus->commision }}" required>
                </div> -->
                <div class="form-group">
                    <label for="material_dispatch_date_first">Material Dispatch Date (1st Lot)</label>
                    <input type="date" name="material_dispatch_date_first" id="material_dispatch_date_first" class="form-control" value="{{ $customerStatus->material_dispatch_date_first }}">
                </div>

                <div class="form-group">
                    <label for="material_dispatch_date_second">Material Dispatch Date (2nd Lot)</label>
                    <input type="date" name="material_dispatch_date_second" id="material_dispatch_date_second" class="form-control" value="{{ $customerStatus->material_dispatch_date_second }}">
                </div>

                <div class="form-group">
                    <label for="installer_name">Installer Name</label>
                    <input type="text" name="installer_name" id="installer_name" class="form-control" value="{{ $customerStatus->installer_name }}">
                </div>

                <div class="form-group">
                    <label for="installation_date">Installation Date</label>
                    <input type="date" name="installation_date" id="installation_date" class="form-control" value="{{ $customerStatus->installation_date }}">
                </div>

                <div class="form-group">
                    <label for="dcr_certificate">DCR Certificate</label>
                    <select name="dcr_certificate" id="dcr_certificate" class="form-control">
                        <option value="No" {{ $customerStatus->dcr_certificate == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->dcr_certificate == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="installation_indent">Installation Indent</label>
                    <select name="installation_indent" id="installation_indent" class="form-control">
                        <option value="No" {{ $customerStatus->installation_indent == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->installation_indent == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="meter_installation">Meter Installation</label>
                    <select name="meter_installation" id="meter_installation" class="form-control">
                        <option value="No" {{ $customerStatus->meter_installation == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->meter_installation == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="Smart Meter" {{ $customerStatus->meter_installation == 'Smart Meter' ? 'selected' : '' }}>Smart Meter</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="meter_configuration">Meter Configuration</label>
                    <select name="meter_configuration" id="meter_configuration" class="form-control">
                        <option value="No" {{ $customerStatus->meter_configuration == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->meter_configuration == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="Selling Certificate" {{ $customerStatus->meter_configuration == 'Selling Certificate' ? 'selected' : '' }}>Selling Certificate</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="installation_submission_operator_name">Installation Submission Operator</label>
                    <input type="text" name="installation_submission_operator_name" id="installation_submission_operator_name" class="form-control" value="{{ $customerStatus->installation_submission_operator_name }}">
                </div>

                <div class="form-group">
                    <label for="subsidy_receive_status_first">Subsidy Receive Status (1st)</label>
                    <select name="subsidy_receive_status_first" id="subsidy_receive_status_first" class="form-control">
                        <option value="No" {{ $customerStatus->subsidy_receive_status_first == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->subsidy_receive_status_first == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subsidy_receive_status_second">Subsidy Receive Status (2nd)</label>
                    <select name="subsidy_receive_status_second" id="subsidy_receive_status_second" class="form-control">
                        <option value="No" {{ $customerStatus->subsidy_receive_status_second == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->subsidy_receive_status_second == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="warranty_certificate_download">Warranty Certificate Download</label>
                    <select name="warranty_certificate_download" id="warranty_certificate_download" class="form-control">
                        <option value="No" {{ $customerStatus->warranty_certificate_download == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $customerStatus->warranty_certificate_download == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="warranty_certificate_delivery_operator_name">Warranty Certificate Delivery Operator</label>
                    <input type="text" name="warranty_certificate_delivery_operator_name" id="warranty_certificate_delivery_operator_name" class="form-control" value="{{ $customerStatus->warranty_certificate_delivery_operator_name }}">
                </div>

                <div class="form-group">
                    <label for="warranty_certificate_delivery_date">Warranty Certificate Delivery Date</label>
                    <input type="date" name="warranty_certificate_delivery_date" id="warranty_certificate_delivery_date" class="form-control" value="{{ $customerStatus->warranty_certificate_delivery_date }}">
                </div>

                <div class="form-group">
                    <label for="warranty_certificate_delivery_operator_name">Remarks</label>
                    <!-- <input type="text" name="updates_remarks" id="updates_remarks" class="form-control" value="{{ $customerStatus->updates_remarks }}"> -->
                    <textarea name="updates_remarks" id="updates_remarks" class="form-control" rows="4" placeholder="Enter any remarks..." >{{ $customerStatus->updates_remarks }}</textarea>

                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('group_id').addEventListener('change', function() {
            let groupId = this.value;
            fetch(`/cpdsolor/public/api/customers-by-group/${groupId}`)
                .then(response => response.json())
                .then(data => {
                    let customerSelect = document.getElementById('customer_id');
                    customerSelect.innerHTML = '<option value="">Select Customer</option>';
                    data.forEach(customer => {
                        customerSelect.innerHTML += `<option value="${customer.id}">${customer.name}</option>`;
                    });
                });
        });
    </script>
@stop
