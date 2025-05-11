@extends('adminlte::page')

@section('title', 'Customer List Payment Received')

@section('content_header')
    <h1>Customer List Payment Received:-({{count($customers)}})</h1>
@stop

@section('content')
    

    <div class="table-responsive">
        <table id="pending-installations-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Group</th>
                    <th>Customer</th>
                    <th>Mobile</th>
                    <th>District Name</th>
                    <th>Division Name</th>
                    <th>Electricity Id</th>
                    <th>KW</th>
                    <th>J Bank name</th>
                    <th>J Branch</th>
                    <th>J ifsc</th>
                    <th>Invoice No</th>
                    <th>Invoice date</th>
                    <th>Total Amount</th>
                    <th>Total Received</th>
                    <th>Status Remarks</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $customer)
               
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($customer->group)->name }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->mobile_no }}</td>
                        <td>{{ $customer->district }}</td>
                        <td>{{ $customer->division }}</td>
                        <td>{{ $customer->electric_account_id }}</td>
                        <td>{{ $customer->kw }}</td>
                        <td>{{ $customer->jan_samarth_bank_name }}</td>
                        <td>{{ $customer->jan_samarth_bank_branch }}</td>
                        <td>{{ $customer->jan_samarth_ifsc_code }}</td>
                        <td>{{ $customer->invoice_no }}</td>
                        @if($customer->invoice_date != '')
                        <td>{{date('F y', strtotime($customer->invoice_date)) }}</td>
                        @else
                        <td>NA</td>
                        @endif
                        
                        <td>{{ $customer->total_amount }}</td>
                        <td>{{ $customer->total_received }}</td>
                        <td>{{ $customer->updates_remarks }}</td>
                       
                        
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
