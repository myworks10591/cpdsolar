@extends('adminlte::page')

@section('title', 'Access Denied')

@section('content_header')
    <h1>Access Denied</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h2 class="text-danger"><i class="fas fa-ban"></i> 403 - Access Denied</h2>
                    <p class="mt-3">You do not have permission to access this page.</p>
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-home"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            margin-top: 50px;
        }
    </style>
@stop
