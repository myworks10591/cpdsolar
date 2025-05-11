@extends('adminlte::page')
@section('title', 'Group List')

@section('content_header')
    <h1>Group List</h1>
@stop

@section('content')
    <a href="{{ route('admin.groups.create') }}" class="btn btn-primary mb-3">Create Group</a>

    <div class="table-responsive">
        <table id="groupsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>Sr No.</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $index => $group)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $group->name }}</td>
                        <td>
                            <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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
            $('#groupsTable').DataTable({
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
