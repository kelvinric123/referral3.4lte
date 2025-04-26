@extends('adminlte::page')

@section('title', 'Consultants Management')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Consultants Management</h1>
        <a href="{{ route('admin.consultants.create') }}" class="btn btn-primary">Add New Consultant</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Hospital</th>
                        <th>Gender</th>
                        <th>Languages</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consultants as $consultant)
                        <tr>
                            <td>{{ $consultant->id }}</td>
                            <td>{{ $consultant->name }}</td>
                            <td>{{ $consultant->specialty->name }}</td>
                            <td>{{ $consultant->hospital->name }}</td>
                            <td>{{ ucfirst($consultant->gender) }}</td>
                            <td>{{ implode(', ', $consultant->languages) }}</td>
                            <td>
                                @if ($consultant->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.consultants.show', $consultant) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.consultants.edit', $consultant) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.consultants.destroy', $consultant) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this consultant?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No consultants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-group form {
            display: inline-block;
        }
    </style>
@stop 