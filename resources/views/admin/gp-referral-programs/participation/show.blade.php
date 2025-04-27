@extends('adminlte::page')

@section('title', 'Manage Program Participation')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manage Program Participation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gp-referral-program-participation.index') }}">Program Participation</a></li>
                    <li class="breadcrumb-item active">Manage Participation</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Program Details</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-list-alt mr-1"></i> Title</strong>
                        <p class="text-muted">{{ $program->title }}</p>
                        <hr>

                        <strong><i class="fas fa-calendar mr-1"></i> Publish Date</strong>
                        <p class="text-muted">{{ $program->publish_date->format('d/m/Y') }}</p>
                        <hr>

                        <strong><i class="fas fa-check-circle mr-1"></i> Status</strong>
                        <p class="text-muted">
                            @if($program->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                        <hr>

                        <strong><i class="fas fa-users mr-1"></i> Participation Statistics</strong>
                        <p class="text-muted">
                            <span class="badge bg-info">{{ $participants->count() }} Participants</span>
                            <span class="badge bg-success">{{ $attendees->count() }} Attendees</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Record GP Participation</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i> Recording participation means the GP has shown interest in this program, 
                            but hasn't necessarily attended it. No loyalty points are awarded for participation alone.
                        </p>
                        
                        <form action="{{ route('admin.gp-referral-program-participation.record-participation', $program) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select GPs who participated:</label>
                                <select class="form-control select2" name="gp_ids[]" multiple="multiple" data-placeholder="Select GPs" style="width: 100%;">
                                    @foreach($gps as $gp)
                                        <option value="{{ $gp->id }}">{{ $gp->name }} ({{ $gp->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Record Participation</button>
                        </form>
                    </div>
                </div>

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Record GP Attendance</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i> When a GP attends this referral program, 
                            they will earn <strong>40 loyalty points</strong>. 
                            (They'll also be automatically marked as participated if not already)
                        </p>
                        
                        <form action="{{ route('admin.gp-referral-program-participation.record-attendance', $program) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select GPs who attended:</label>
                                <select class="form-control select2" name="gp_ids[]" multiple="multiple" data-placeholder="Select GPs" style="width: 100%;">
                                    @foreach($gps as $gp)
                                        <option value="{{ $gp->id }}">{{ $gp->name }} ({{ $gp->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Record Attendance & Award Points</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Participants List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->name }}</td>
                                            <td>{{ $participant->email }}</td>
                                            <td>
                                                {{ $participant->pivot->created_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No participants yet</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Attendees List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendees as $attendee)
                                        <tr>
                                            <td>{{ $attendee->name }}</td>
                                            <td>{{ $attendee->email }}</td>
                                            <td>{{ $attendee->pivot->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-success">+{{ $attendee->pivot->points_awarded }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No attendees yet</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap',
                width: '100%'
            });
        });
    </script>
@stop 