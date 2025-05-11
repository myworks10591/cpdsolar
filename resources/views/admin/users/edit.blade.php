@extends('adminlte::page')
@section('title', 'Edit User')
@section('content_header')
    <h1>Edit User</h1>
@stop
@section('content')
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label>Group:</label>
    <select name="group_id" class="form-control">
        <option value="">Select Group (Optional)</option>
        @foreach ($groups as $group)
            <option value="{{ $group->id }}" {{ $user->group_id == $group->id ? 'selected' : '' }}>
                {{ $group->name }}
            </option>
        @endforeach
    </select>
    </div>
        <button type="submit" class="btn btn-success">Update User</button>
    </form>
@stop
