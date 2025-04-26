@extends('adminlte::page')

@section('title', 'Booking Agents')

@section('content_header')
    <h1>Booking Agents</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">List of Booking Agents</h3>
                <a href="{{ route('admin.booking-agents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Booking Agent
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookingAgents as $agent)
                            <tr>
                                <td>{{ $agent->id }}</td>
                                <td>{{ $agent->name }}</td>
                                <td>
                                    <a href="{{ route('admin.companies.show', $agent->company_id) }}">
                                        {{ $agent->company->name }}
                                    </a>
                                </td>
                                <td>{{ $agent->email }}</td>
                                <td>{{ $agent->phone }}</td>
                                <td>{{ $agent->position }}</td>
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
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="deleteConfirmation('{{ $agent->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $agent->id }}" 
                                              action="{{ route('admin.booking-agents.destroy', $agent) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No booking agents found.</td>
                            </tr>
                        @endforelse
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
        function deleteConfirmation(id) {
            if (confirm('Are you sure you want to delete this booking agent?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@stop 