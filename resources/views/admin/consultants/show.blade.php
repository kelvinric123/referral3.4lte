@extends('adminlte::page')

@section('title', 'Consultant Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Consultant Details</h1>
        <div>
            <a href="{{ route('admin.consultants.edit', $consultant) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.consultants.index') }}" class="btn btn-secondary">Back to List</a>
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
                        <td>{{ $consultant->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $consultant->name }}</td>
                    </tr>
                    <tr>
                        <th>Hospital</th>
                        <td>{{ $consultant->hospital->name }}</td>
                    </tr>
                    <tr>
                        <th>Specialty</th>
                        <td>{{ $consultant->specialty->name }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ ucfirst($consultant->gender) }}</td>
                    </tr>
                    <tr>
                        <th>Languages</th>
                        <td>{{ implode(', ', $consultant->languages) }}</td>
                    </tr>
                    <tr>
                        <th>Qualifications</th>
                        <td>{{ $consultant->qualifications }}</td>
                    </tr>
                    <tr>
                        <th>Experience</th>
                        <td>{{ $consultant->experience }}</td>
                    </tr>
                    <tr>
                        <th>Bio</th>
                        <td>{{ $consultant->bio ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $consultant->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $consultant->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($consultant->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $consultant->created_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $consultant->updated_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop 