@extends('adminlte::page')

@section('title', 'Dispatches')

@section('content_header')
    <h1>Dispatches</h1>
@stop

@section('content')
    <a href="{{ route('admin.dispatches.create') }}" class="btn btn-primary">Create New Dispatch</a>

    <div class="table-responsive mt-4">
        <table id="dispatches-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Dispatch No.</th>
                    <th>Customer</th>
                    <!-- <th>Product</th> -->
                    <th>Dispatched Date</th>
                    <th>Driver</th>
                    <th>Van</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Last Updated on</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dispatches as $index => $dispatch)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dispatch->dispatch_number }}</td>
                        <td>{{ $dispatch->customer->name ?? '-' }}</td>
                        <!-- <td>{{ $dispatch->product_name }}</td> -->
                        <td>{{ $dispatch->dispatch_date }}</td>
                        <td>{{ $dispatch->driver_name }}</td>
                        <td>{{ $dispatch->van_number }}</td>
                        <td>{{ $dispatch->driver_mobile }}</td>
                        <td>{{ $dispatch->status }}</td>
                        <td>{{ $dispatch->remarks }}</td>
                        <td>{{ $dispatch->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.dispatches.edit', $dispatch->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.dispatches.destroy', $dispatch->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this dispatch?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- DataTables export dependencies -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(function () {
            $('#dispatches-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Dispatches_Export',
                        className: 'btn btn-success mb-6',
                        exportOptions: {
                            columns: ':not(:last-child)' // exclude Actions column
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
@endsection
