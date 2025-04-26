@extends('adminlte::page')

@section('title', 'Service Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Service Details</h1>
        <div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $service->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $service->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $service->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cost</th>
                        <td>RM {{ number_format($service->cost, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $service->duration ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Hospital</th>
                        <td>{{ $service->hospital->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($service->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $service->created_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $service->updated_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop 