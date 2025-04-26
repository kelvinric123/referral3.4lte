@extends('adminlte::page')

@section('title', 'GP Management')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>General Practitioners Management</h1>
        <a href="{{ route('admin.gps.create') }}" class="btn btn-primary">Add New GP</a>
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
                        <th>Clinic</th>
                        <th>Qualifications</th>
                        <th>Experience</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gps as $gp)
                        <tr>
                            <td>{{ $gp->id }}</td>
                            <td>{{ $gp->name }}</td>
                            <td>{{ $gp->clinic->name }}</td>
                            <td>{{ $gp->qualifications }}</td>
                            <td>{{ $gp->years_experience }} years</td>
                            <td>{{ ucfirst($gp->gender) }}</td>
                            <td>
                                @if ($gp->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.gps.show', $gp) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.gps.edit', $gp) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gps.destroy', $gp) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this GP?');">
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
                            <td colspan="8" class="text-center">No GPs found.</td>
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