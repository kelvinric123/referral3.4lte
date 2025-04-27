@extends('adminlte::page')

@section('title', 'Specialty Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Specialty Details</h1>
        <div>
            <a href="{{ route('hospital.specialties.edit', $specialty) }}" class="btn btn-primary">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <a href="{{ route('hospital.specialties.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $specialty->name }}</h3>
            <div class="card-tools">
                @if($specialty->is_active)
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <strong>Description:</strong>
                    <p>{{ $specialty->description ?? 'No description provided.' }}</p>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-md mr-1"></i> Consultants in this Specialty
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($specialty->consultants->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-1"></i> No consultants have been assigned to this specialty yet.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Qualification</th>
                                                <th>Experience</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($specialty->consultants as $consultant)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('hospital.consultants.show', $consultant) }}">
                                                            {{ $consultant->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $consultant->qualification ?? 'N/A' }}</td>
                                                    <td>{{ $consultant->years_experience ?? '0' }} years</td>
                                                    <td>
                                                        @if($consultant->is_active)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Specialty details page loaded.');
    </script>
@stop 