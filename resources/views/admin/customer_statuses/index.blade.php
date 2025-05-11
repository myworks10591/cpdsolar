@extends('adminlte::page')

@section('title', 'Customer Status')

@section('content_header')
    <h1>Customer Status</h1>
@stop

@section('content')
    <!-- <a href="{{ route('admin.customer_statuses.create') }}" class="btn btn-primary mb-3">Add Customer Status</a> -->
    <a href="{{ route('admin.customersstatus.export') }}" class="btn btn-success mb-3">Export to Excel</a>

    <div class="table-responsive">
        <table id="customerStatusTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Group Name</th>
                    <th>Customer Name</th>
                    <th>Mobile No.</th>
                    <th>Electricity Id</th>
                    <th>KW</th>
                    <th>Invoice No.</th>
                    <th>Installer Name</th>
                    <th>Meter Installation</th>
                    <th>Online Installer Name</th>
                    <th>Last Updated on</th>
                    <th>Remarks</th>
                    <!-- <th>Warranty Certificate</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $index => $status)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $status->group->name }}</td>
                        <td>{{ $status->customer->name }}</td>
                        <td>{{ $status->customer->mobile_no }}</td>
                        <td>{{ $status->customer->electric_account_id }}</td>
                        <td>{{ $status->customer->kw }}</td>                        <td>{{ $status->invoice_no }}</td>
                        <td>{{ $status->installer_name }}</td>
                        <td>{{ $status->meter_installation }}</td>
                        <td>{{ $status->installation_submission_operator_name }}</td>
                        <td>{{ $status->updates_remarks }}</td>
                        <td>{{ $status->updated_at }}</td>
                        <!-- <td>{{ $status->warranty_certificate_download }}</td> -->
                        <td>
                            <a href="{{ route('admin.customer_statuses.edit', $status->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.customer_statuses.show', $status->id) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('admin.customer_statuses.destroy', $status->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <!-- DataTables Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <!-- DataTables Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#customerStatusTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    zeroRecords: "No matching records found",
                }
            });
        });
    </script>
@stop
