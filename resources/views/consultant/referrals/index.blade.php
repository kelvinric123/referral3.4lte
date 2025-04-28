@extends('adminlte::page')

@section('title', 'My Referrals')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>My Referrals</h1>
    </div>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Referrals</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('consultant.referrals.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="No Show" {{ request('status') == 'No Show' ? 'selected' : '' }}>No Show</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hospital_id">Hospital</label>
                            <select class="form-control" id="hospital_id" name="hospital_id">
                                <option value="">All Hospitals</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="specialty_id">Specialty</label>
                            <select class="form-control" id="specialty_id" name="specialty_id">
                                <option value="">All Specialties</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ request('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="referrer_type">Referrer Type</label>
                            <select class="form-control" id="referrer_type" name="referrer_type">
                                <option value="">All Types</option>
                                <option value="GP" {{ request('referrer_type') == 'GP' ? 'selected' : '' }}>GP</option>
                                <option value="BookingAgent" {{ request('referrer_type') == 'BookingAgent' ? 'selected' : '' }}>Booking Agent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" id="gp_filter" style="{{ request('referrer_type') == 'GP' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="gp_id">GP Doctor</label>
                            <select class="form-control" id="gp_id" name="gp_id">
                                <option value="">All GPs</option>
                                @foreach($gps as $gp)
                                    <option value="{{ $gp->id }}" {{ request('gp_id') == $gp->id ? 'selected' : '' }}>
                                        {{ $gp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="booking_agent_filter" style="{{ request('referrer_type') == 'BookingAgent' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="booking_agent_id">Booking Agent</label>
                            <select class="form-control" id="booking_agent_id" name="booking_agent_id">
                                <option value="">All Booking Agents</option>
                                @foreach($bookingAgents as $agent)
                                    <option value="{{ $agent->id }}" {{ request('booking_agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                placeholder="Patient name, ID..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="">All Priorities</option>
                                <option value="Normal" {{ request('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Urgent" {{ request('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="Emergency" {{ request('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('consultant.referrals.index') }}" class="btn btn-default">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Referrals List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="referrals-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Hospital</th>
                            <th>Specialty</th>
                            <th>Referrer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td>{{ $referral->id }}</td>
                                <td>
                                    <strong>{{ $referral->patient_name }}</strong><br>
                                    <small>ID: {{ $referral->patient_id }}</small>
                                </td>
                                <td>{{ $referral->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $referral->specialty->name ?? 'N/A' }}</td>
                                <td>
                                    @if($referral->referrer_type == 'GP' && $referral->gp)
                                        <span class="badge badge-info">GP</span> {{ $referral->gp->name }}
                                    @elseif($referral->referrer_type == 'BookingAgent' && $referral->bookingAgent)
                                        <span class="badge badge-primary">Booking Agent</span> {{ $referral->bookingAgent->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $referral->created_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Pending' => 'secondary',
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            'No Show' => 'warning',
                                            'Completed' => 'primary'
                                        ][$referral->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">{{ $referral->status }}</span>
                                </td>
                                <td>
                                    @php
                                        $priorityClass = [
                                            'Normal' => 'secondary',
                                            'Urgent' => 'warning',
                                            'Emergency' => 'danger'
                                        ][$referral->priority] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $priorityClass }}">{{ $referral->priority }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('consultant.referrals.show', $referral->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No referrals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $referrals->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Handle referrer type filter visibility
            $('#referrer_type').change(function() {
                if ($(this).val() === 'GP') {
                    $('#gp_filter').show();
                    $('#booking_agent_filter').hide();
                } else if ($(this).val() === 'BookingAgent') {
                    $('#gp_filter').hide();
                    $('#booking_agent_filter').show();
                } else {
                    $('#gp_filter').hide();
                    $('#booking_agent_filter').hide();
                }
            });
        });
    </script>
@stop 