@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <h1>Customers</h1>
@stop

@section('content')
    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Create New Customer</a>
    <a href="{{ route('admin.customers.export') }}" class="btn btn-success">Export to Excel</a>
    

    <div class="table-responsive mt-4">
        <table id="customers-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Operator Name</th>
                    <th>Group Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>IFSC Code</th>
                    <th>Electricity Id</th>
                    <th>Kw</th>
                    <th>Account Number</th>
                    <th>Total Amount</th>
                    <th>Due Amount</th>
                    <th>Remarks</th>
                    <th>created date</th>
                    <th>Updated date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as  $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($customer->user)->name }}</td>
                        <td>{{ optional($customer->group)->name }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->mobile_no }}</td>
                        <td>{{ $customer->jan_samarth_ifsc_code }}</td>
                        <td>{{ $customer->electric_account_id }}</td>
                        <td>{{ $customer->kw }}</td>
                        <td>{{ $customer->account_no }}</td>
                        <td>{{ number_format($customer->total_amount, 2) }}</td>
                        <td>{{ number_format($customer->due_amount, 2) }}</td>
                        <td>{{ $customer->remarks }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('css')
    <!-- DataTables Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <!-- DataTables Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#customers-table').DataTable({
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
@endsection
