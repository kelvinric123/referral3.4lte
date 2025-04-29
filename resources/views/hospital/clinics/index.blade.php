@extends('adminlte::page')

@section('title', 'Clinics Directory')

@section('content_header')
    <h1>Clinics Directory</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Clinics</h3>
            <div class="float-right">
                <a href="{{ route('hospital.clinics.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Add Clinic
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($clinics->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> No clinics are currently available in the system.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clinics as $clinic)
                                <tr>
                                    <td>{{ $clinic->id }}</td>
                                    <td>{{ $clinic->name }}</td>
                                    <td>
                                        {{ $clinic->city }}, {{ $clinic->state }}<br>
                                        <small>{{ $clinic->address }}</small>
                                    </td>
                                    <td>
                                        @if($clinic->phone)
                                            <i class="fas fa-phone mr-1"></i> {{ $clinic->phone }}<br>
                                        @endif
                                        @if($clinic->email)
                                            <i class="fas fa-envelope mr-1"></i> {{ $clinic->email }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($clinic->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('hospital.clinics.show', $clinic) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye mr-1"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 