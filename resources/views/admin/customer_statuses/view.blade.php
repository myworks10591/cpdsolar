@extends('adminlte::page')

@section('title', 'Customer Status Details')

@section('content_header')
    <h1>Customer Status Details</h1>
@stop

@section('content')
<a href="{{ route('admin.customer_statuses.index') }}" class="btn btn-secondary mb-3">Back to List</a>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Customer Status Information</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Group Name</th>
                <td>{{ $customerStatus->group->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $customerStatus->customer->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Customer Mobile Number</th>
                <td>{{ $customerStatus->customer->mobile_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Electric Account id</th>
                <td>{{ $customerStatus->customer->electric_account_id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Division Name</th>
                <td>{{ $customerStatus->customer->division ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>KW</th>
                <td>{{ $customerStatus->customer->kw ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Invoice No.</th>
                <td>{{ $customerStatus->invoice_no }}</td>
            </tr>
            <tr>
                <th>Material Dispatch Date (1st Lot)</th>
                <td>{{ $customerStatus->material_dispatch_date_first }}</td>
            </tr>
            <tr>
                <th>Material Dispatch Date (2nd Lot)</th>
                <td>{{ $customerStatus->material_dispatch_date_second }}</td>
            </tr>
            <tr>
                <th>Installer Name</th>
                <td>{{ $customerStatus->installer_name }}</td>
            </tr>
            <tr>
                <th>Installation Date</th>
                <td>{{ $customerStatus->installation_date }}</td>
            </tr>
            <tr>
                <th>DCR Certificate</th>
                <td>{{ $customerStatus->dcr_certificate }}</td>
            </tr>
            <tr>
                <th>Installation Indent</th>
                <td>{{ $customerStatus->installation_indent }}</td>
            </tr>
            <tr>
                <th>Meter Installation</th>
                <td>{{ $customerStatus->meter_installation }}</td>
            </tr>
            <tr>
                <th>Meter Configuration</th>
                <td>{{ $customerStatus->meter_configuration }}</td>
            </tr>
            <tr>
                <th>Online Installer Name</th>
                <td>{{ $customerStatus->installation_submission_operator_name }}</td>
            </tr>
            <tr>
                <th>Subsidy Receive Status (1st)</th>
                <td>{{ $customerStatus->subsidy_receive_status_first }}</td>
            </tr>
            <tr>
                <th>Subsidy Receive Status (2nd)</th>
                <td>{{ $customerStatus->subsidy_receive_status_second }}</td>
            </tr>
            <tr>
                <th>Warranty Certificate Download</th>
                <td>{{ $customerStatus->warranty_certificate_download }}</td>
            </tr>
            <tr>
                <th>Warranty Certificate Delivery Operator Name</th>
                <td>{{ $customerStatus->warranty_certificate_delivery_operator_name }}</td>
            </tr>
            <tr>
                <th>Warranty Certificate Delivery Date</th>
                <td>{{ $customerStatus->warranty_certificate_delivery_date }}</td>
            </tr>
        </table>
    </div>
</div>
@stop
