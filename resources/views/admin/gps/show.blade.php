@extends('adminlte::page')

@section('title', 'GP Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>GP Details</h1>
        <div>
            <a href="{{ route('admin.gps.edit', $gp) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.gps.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td>{{ $gp->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $gp->name }}</td>
                                </tr>
                                <tr>
                                    <th>Clinic</th>
                                    <td>{{ $gp->clinic->name }}</td>
                                </tr>
                                <tr>
                                    <th>Qualifications</th>
                                    <td>{{ $gp->qualifications }}</td>
                                </tr>
                                <tr>
                                    <th>Years of Experience</th>
                                    <td>{{ $gp->years_experience }} years</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($gp->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($gp->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Contact & Login Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Email</th>
                                    <td>{{ $gp->email }}</td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>{{ $gp->password }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $gp->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Languages</th>
                                    <td>
                                        @foreach($gp->languages as $language)
                                            <span class="badge badge-info">{{ $language }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $gp->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $gp->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.gps.destroy', $gp) }}" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this GP?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete GP
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop 