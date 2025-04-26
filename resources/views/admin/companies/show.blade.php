@extends('adminlte::page')

@section('title', 'Company Details')

@section('content_header')
    <h1>Company Details</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $company->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID</th>
                            <td>{{ $company->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $company->name }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $company->address }}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $company->city }}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $company->state }}</td>
                        </tr>
                        <tr>
                            <th>Postal Code</th>
                            <td>{{ $company->postal_code }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $company->country }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $company->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $company->email }}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>
                                @if ($company->website)
                                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($company->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" 
                                onclick="deleteConfirmation('{{ $company->id }}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <form id="delete-form-{{ $company->id }}" 
                              action="{{ route('admin.companies.destroy', $company) }}" 
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Agents</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.booking-agents.create', ['company_id' => $company->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Booking Agent
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookingAgents as $agent)
                                    <tr>
                                        <td>{{ $agent->id }}</td>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->phone }}</td>
                                        <td>
                                            @if ($agent->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.booking-agents.show', $agent) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.booking-agents.edit', $agent) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No booking agents found for this company.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
        function deleteConfirmation(id) {
            if (confirm('Are you sure you want to delete this company?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@stop 