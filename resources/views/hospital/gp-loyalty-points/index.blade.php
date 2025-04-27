@extends('adminlte::page')

@section('title', 'GP Loyalty Points')

@section('content_header')
    <h1>GP Loyalty Points</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">GP Loyalty Points Summary</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>GP Name</th>
                            <th>Clinic</th>
                            <th>Total Points</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gps as $gp)
                            <tr>
                                <td>{{ $gp->name }}</td>
                                <td>{{ $gp->clinic->name ?? 'N/A' }}</td>
                                <td>{{ $gp->totalPoints }}</td>
                                <td>
                                    @if($gp->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('hospital.gp-loyalty-points.show', $gp->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 