@extends('adminlte::page')

@section('title', 'Booking Agent Details')

@section('content_header')
    <h1>Booking Agent Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $bookingAgent->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.booking-agents.index') }}" class="btn btn-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%">ID</th>
                    <td>{{ $bookingAgent->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $bookingAgent->name }}</td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td>
                        <a href="{{ route('admin.companies.show', $bookingAgent->company_id) }}">
                            {{ $bookingAgent->company->name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $bookingAgent->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $bookingAgent->phone }}</td>
                </tr>
                <tr>
                    <th>Position</th>
                    <td>{{ $bookingAgent->position }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($bookingAgent->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $bookingAgent->created_at }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $bookingAgent->updated_at }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <div class="btn-group">
                <a href="{{ route('admin.booking-agents.edit', $bookingAgent) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button type="button" class="btn btn-danger" 
                        onclick="deleteConfirmation('{{ $bookingAgent->id }}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <form id="delete-form-{{ $bookingAgent->id }}" 
                      action="{{ route('admin.booking-agents.destroy', $bookingAgent) }}" 
                      method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
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