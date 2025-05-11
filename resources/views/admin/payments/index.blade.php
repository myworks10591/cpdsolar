@extends('adminlte::page')

@section('title', 'Payments')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')
    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary mb-3">Add Payment</a>

    <div class="table-responsive">
        <table id="payments-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Group</th>
                    <th>Customer</th>
                    <th>Received Amount</th>
                    <th>Payment Mode</th>
                    <th>Received Date</th>
                    <th>Actions</th>
                    <th>Status Sync</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->group->name }}</td>
                        <td>{{ $payment->customer->name }} ({{ $payment->customer->mobile_no }})</td>
                        <td>{{ number_format($payment->received_amount, 2) }}</td>
                        <td>{{ ucfirst($payment->payment_mode) }}</td>
                        <td>{{ $payment->payment_received_date }}</td>
                        <td>
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payment?');">Delete</button>
                            </form>
                        </td>
                        <td>
                            @php
                                $statusExists = \App\Models\CustomerStatus::where('customer_id', $payment->customer_id)->exists();
                            @endphp
                            <button class="btn btn-primary btn-status"
                                    data-customer-id="{{ $payment->customer_id }}"
                                    {{ $statusExists ? 'disabled' : '' }}>
                                {{ $statusExists ? 'Status Added' : 'Add Status' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <!-- DataTables + Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@stop

@section('js')
    <!-- jQuery (make sure it's loaded first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables core -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- DataTables buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
         $('.btn-status').click(function () {
                var customerId = $(this).data('customer-id');
                var button = $(this);

                $.ajax({
                    url: "{{ route('admin.sync-customers') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        customer_id: customerId
                    },
                    success: function (response) {
                        button.prop('disabled', true).text('Status Added');
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        $(document).ready(function () {
            $('#payments-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip', // Buttons layout
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export the Data',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Export only Sr No. to Received Date
                        }
                    }
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                }
            });

           
        });
    </script>
@stop
