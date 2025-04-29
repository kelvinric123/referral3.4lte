@extends('adminlte::page')

@section('title', 'GP Doctors Directory')

@section('content_header')
    <h1>GP Doctors Directory</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All GP Doctors</h3>
            <div class="float-right">
                <a href="{{ route('hospital.gps.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Add GP Doctor
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($gps->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> No GP Doctors are currently available in the system.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Clinic</th>
                                <th>Experience</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gps as $gp)
                                <tr>
                                    <td>{{ $gp->id }}</td>
                                    <td>{{ $gp->name }}</td>
                                    <td>
                                        @if($gp->clinic)
                                            <a href="{{ route('hospital.clinics.show', $gp->clinic) }}">
                                                {{ $gp->clinic->name }}
                                            </a><br>
                                            <small>{{ $gp->clinic->city }}, {{ $gp->clinic->state }}</small>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td>
                                        {{ $gp->years_experience ?? '0' }} years<br>
                                        <small>{{ $gp->qualifications ?? 'No qualifications listed' }}</small>
                                    </td>
                                    <td>
                                        @if($gp->email)
                                            <i class="fas fa-envelope mr-1"></i> {{ $gp->email }}<br>
                                        @endif
                                        @if($gp->phone)
                                            <i class="fas fa-phone mr-1"></i> {{ $gp->phone }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($gp->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('hospital.gps.show', $gp) }}" class="btn btn-sm btn-info">
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