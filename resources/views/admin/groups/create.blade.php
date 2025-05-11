<!-- resources/views/admin/groups/create.blade.php -->
@extends('adminlte::page')
@section('title', 'Group Create')
@section('content')
    <h1>Create Group</h1>
    <form action="{{ route('admin.groups.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection
