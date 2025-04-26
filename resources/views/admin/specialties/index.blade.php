@extends('adminlte::page')

@section('title', 'Specialties Management')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Specialties Management</h1>
        <a href="{{ route('admin.specialties.create') }}" class="btn btn-primary">Add New Specialty</a>
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
                        <th>Hospital</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($specialties as $specialty)
                        <tr>
                            <td>{{ $specialty->id }}</td>
                            <td>{{ $specialty->name }}</td>
                            <td>{{ $specialty->hospital->name }}</td>
                            <td>
                                @if ($specialty->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.specialties.show', $specialty) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.specialties.edit', $specialty) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.specialties.destroy', $specialty) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this specialty?');">
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
                            <td colspan="5" class="text-center">No specialties found.</td>
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