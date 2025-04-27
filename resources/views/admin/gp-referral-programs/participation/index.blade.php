@extends('adminlte::page')

@section('title', 'GP Referral Program Participation')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>GP Referral Program Participation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Program Participation</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage GP Referral Program Participation</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Publish Date</th>
                                        <th>Participants</th>
                                        <th>Attendees</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programs as $program)
                                    <tr>
                                        <td>{{ $program->id }}</td>
                                        <td>{{ $program->title }}</td>
                                        <td>{{ $program->publish_date->format('d/m/Y') }}</td>
                                        <td>{{ $program->participants()->count() }}</td>
                                        <td>{{ $program->attendees()->count() }}</td>
                                        <td>
                                            @if($program->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.gp-referral-program-participation.show', $program) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Manage
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize any needed JS here
        });
    </script>
@stop 