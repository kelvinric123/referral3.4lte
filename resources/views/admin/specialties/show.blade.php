@extends('adminlte::page')

@section('title', 'Specialty Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Specialty Details</h1>
        <div>
            <a href="{{ route('admin.specialties.edit', $specialty) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.specialties.index') }}" class="btn btn-secondary">Back to List</a>
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
                        <td>{{ $specialty->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $specialty->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $specialty->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Hospital</th>
                        <td>{{ $specialty->hospital->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($specialty->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $specialty->created_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $specialty->updated_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop 