@extends('adminlte::page')

@section('title', 'Consultants Directory')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Consultants Directory</h1>
        <a href="{{ route('hospital.consultants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Add New Consultant
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Consultants</h3>
        </div>
        <div class="card-body">
            @if($consultants->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> No consultants have been added yet. Click the "Add New Consultant" button to get started.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Specialty</th>
                                <th>Experience</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultants as $consultant)
                                <tr>
                                    <td>{{ $consultant->id }}</td>
                                    <td>{{ $consultant->name }}</td>
                                    <td>
                                        @if($consultant->specialty)
                                            <a href="{{ route('hospital.specialties.show', $consultant->specialty) }}">
                                                {{ $consultant->specialty->name }}
                                            </a>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td>
                                        {{ $consultant->years_experience ?? '0' }} years<br>
                                        <small>{{ $consultant->qualification ?? 'No qualifications listed' }}</small>
                                    </td>
                                    <td>
                                        @if($consultant->email)
                                            <i class="fas fa-envelope mr-1"></i> {{ $consultant->email }}<br>
                                        @endif
                                        @if($consultant->phone)
                                            <i class="fas fa-phone mr-1"></i> {{ $consultant->phone }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($consultant->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hospital.consultants.show', $consultant) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('hospital.consultants.edit', $consultant) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $consultant->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $consultant->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $consultant->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $consultant->id }}">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete the consultant <strong>{{ $consultant->name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('hospital.consultants.destroy', $consultant) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 