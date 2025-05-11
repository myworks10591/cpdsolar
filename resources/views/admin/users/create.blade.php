@extends('adminlte::page')
@section('title', 'Add User')
@section('content_header')
    <h1>Add User</h1>
@stop
@section('content')
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label>Group</label>
        <select name="group_id" class="form-control">
            <option value="">Select Group (Optional)</option>
            @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
        </div>
        <button type="submit" class="btn btn-success">Add User</button>
    </form>
@stop
