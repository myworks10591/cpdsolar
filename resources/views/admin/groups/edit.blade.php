<!-- resources/views/admin/groups/edit.blade.php -->
@extends('adminlte::page')
@section('title', 'Group Edit')

@section('content')
    <h1>Edit Group</h1>
    <form action="{{ route('admin.groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $group->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
