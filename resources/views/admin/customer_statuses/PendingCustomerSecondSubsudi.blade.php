@extends('adminlte::page')

@section('title', 'Pending Customer Second Subsidy')

@section('content_header')
    <h1>Pending Customer Second Subsidy:-({{count($customers)}})</h1>
@stop

@section('content')
    

    <div class="table-responsive">
        <table id="pending-installations-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Operator Name</th>
                    <th>Group Name</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>District</th>
                    <th>Electricity Id</th>
                    <th>Kw</th>
                    <th>Total Amount</th>
                    <th>Due Amount</th>
                    <th>Remarks</th>
                    <th>Updated date</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($customer->user)->name }}</td>
                        <td>{{ optional($customer->group)->name }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->mobile_no }}</td>
                        <td>{{ $customer->district }}</td>
                        <td>{{ $customer->electric_account_id }}</td>
                        <td>{{ $customer->kw }}</td>
                        <td>{{ number_format($customer->total_amount, 2) }}</td>
                        <td>{{ number_format($customer->due_amount, 2) }}</td>
                        <td>{{ $customer->updates_remarks }}</td>
                        <td>{{ $customer->cust_updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.customer_statuses.edit', $customer->custid) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@stop

@section('js')
    <!-- DataTables + Buttons Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#pending-installations-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Pending Installations',
                        className: 'btn-success', // ✅ makes it green using Bootstrap
                        exportOptions: {
                            columns: ':visible'
                        }
                      }
                ],
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
