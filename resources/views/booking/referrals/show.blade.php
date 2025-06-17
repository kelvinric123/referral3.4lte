@extends('adminlte::page')

@section('title', 'View Referral')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Referral #{{ $referral->id }}</h1>
        <div>
            <a href="{{ route('booking.referrals.index') }}" class="btn btn-default mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            @if($referral->status === 'Pending')
                <a href="{{ route('booking.referrals.edit', $referral->id) }}" class="btn btn-primary mr-2">
                    <i class="fas fa-edit"></i> Edit Referral
                </a>
                <form action="{{ route('booking.referrals.cancel', $referral->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this referral?')">
                        <i class="fas fa-times"></i> Cancel Referral
                    </button>
                </form>
            @endif
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Patient Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-injured mr-2"></i>
                        Patient Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>Name</dt>
                                <dd>{{ $referral->patient_name }}</dd>
                                
                                <dt>ID Type</dt>
                                <dd>
                                    @if($referral->id_type == 'ic')
                                        <span class="badge badge-info">Malaysian IC</span>
                                    @else
                                        <span class="badge badge-warning">Passport</span>
                                    @endif
                                </dd>
                                
                                <dt>{{ $referral->id_type == 'ic' ? 'IC Number' : 'Passport Number' }}</dt>
                                <dd>{{ $referral->patient_id }}</dd>
                                
                                <dt>Date of Birth</dt>
                                <dd>{{ $referral->patient_dob ? date('d M Y', strtotime($referral->patient_dob)) : 'N/A' }}</dd>
                                
                                <dt>Age</dt>
                                <dd>{{ $referral->patient_age ? $referral->patient_age . ' years old' : 'N/A' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Contact Number</dt>
                                <dd>
                                    @if($referral->patient_contact)
                                        <i class="fas fa-phone mr-1 text-muted"></i>
                                        {{ $referral->patient_contact }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </dd>
                                
                                <dt>Email</dt>
                                <dd>
                                    @if($referral->patient_email)
                                        <i class="fas fa-envelope mr-1 text-muted"></i>
                                        {{ $referral->patient_email }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </dd>
                                
                                <dt>Address</dt>
                                <dd>
                                    @if($referral->patient_address)
                                        <i class="fas fa-map-marker-alt mr-1 text-muted"></i>
                                        {{ $referral->patient_address }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hospital & Consultant Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hospital mr-2"></i>
                        Hospital & Consultant Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>Hospital</dt>
                                <dd>{{ $referral->hospital->name ?? 'N/A' }}</dd>
                                
                                <dt>Specialty</dt>
                                <dd>{{ $referral->specialty->name ?? 'N/A' }}</dd>
                                
                                <dt>Consultant</dt>
                                <dd>{{ $referral->consultant->name ?? 'N/A' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Preferred Date</dt>
                                <dd>{{ $referral->preferred_date ? date('d M Y', strtotime($referral->preferred_date)) : 'N/A' }}</dd>
                                
                                <dt>Priority</dt>
                                <dd>
                                    @switch($referral->priority)
                                        @case('Emergency')
                                            <span class="badge badge-danger">Emergency</span>
                                            @break
                                        @case('Urgent')
                                            <span class="badge badge-warning">Urgent</span>
                                            @break
                                        @case('Normal')
                                            <span class="badge badge-success">Normal</span>
                                            @break
                                        @default
                                            <span class="badge badge-info">{{ $referral->priority }}</span>
                                    @endswitch
                                </dd>
                                
                                <dt>Created</dt>
                                <dd>{{ $referral->created_at->format('d M Y, h:i A') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-notes-medical mr-2"></i>
                        Medical Information
                    </h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Diagnosis/Condition</dt>
                        <dd>{{ $referral->diagnosis ?? 'N/A' }}</dd>
                        
                        <dt>Clinical History</dt>
                        <dd>{{ $referral->clinical_history ?? 'None provided' }}</dd>
                        
                        <dt>Additional Remarks</dt>
                        <dd>{{ $referral->remarks ?? 'None provided' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Referral Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>
                        Referral Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @php
                            $statusClass = [
                                'Pending' => 'secondary',
                                'Approved' => 'success',
                                'Rejected' => 'danger',
                                'No Show' => 'warning',
                                'Completed' => 'primary',
                                'Cancelled' => 'dark'
                            ][$referral->status] ?? 'secondary';
                        @endphp
                        <h4>
                            <span class="badge badge-{{ $statusClass }} badge-lg">
                                {{ $referral->status }}
                            </span>
                        </h4>
                    </div>

                    @if($referral->status === 'Pending')
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            This referral is pending approval from the hospital.
                        </div>
                    @elseif($referral->status === 'Approved')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            This referral has been approved. The hospital will contact the patient.
                        </div>
                    @elseif($referral->status === 'Rejected')
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle mr-2"></i>
                            This referral has been rejected by the hospital.
                        </div>
                    @elseif($referral->status === 'Completed')
                        <div class="alert alert-primary">
                            <i class="fas fa-trophy mr-2"></i>
                            This referral has been completed successfully.
                        </div>
                    @elseif($referral->status === 'Cancelled')
                        <div class="alert alert-dark">
                            <i class="fas fa-ban mr-2"></i>
                            This referral has been cancelled.
                        </div>
                    @endif

                    <!-- Status History -->
                    @if($referral->statusHistories && $referral->statusHistories->count() > 0)
                        <hr>
                        <h6>Status History</h6>
                        <div class="timeline">
                            @foreach($referral->statusHistories->sortByDesc('created_at') as $history)
                                <div class="time-label">
                                    <span class="bg-info">{{ $history->created_at->format('d M Y') }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-circle bg-primary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">{{ $history->status }}</h3>
                                        <div class="timeline-body">
                                            {{ $history->comments ?? 'Status updated' }}
                                        </div>
                                        <div class="timeline-footer">
                                            <small class="text-muted">{{ $history->created_at->format('h:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            @if($referral->status === 'Pending')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group-vertical btn-block">
                            <a href="{{ route('booking.referrals.edit', $referral->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i> Edit Referral
                            </a>
                            <form action="{{ route('booking.referrals.cancel', $referral->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to cancel this referral?')">
                                    <i class="fas fa-times mr-2"></i> Cancel Referral
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .badge-lg {
            font-size: 1.1em;
            padding: 0.5em 1em;
        }
        .timeline {
            margin: 0;
        }
        .timeline > div {
            margin-bottom: 15px;
        }
        .timeline .time-label > span {
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 0.8em;
        }
        .timeline-item {
            background: #f4f4f4;
            border-radius: 3px;
            margin-left: 30px;
            margin-top: -15px;
            padding: 10px;
        }
        .timeline-header {
            font-size: 1em;
            margin: 0 0 5px 0;
        }
        .timeline-body {
            margin-bottom: 10px;
        }
        .timeline-footer {
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
@stop

@section('js')
    <script> console.log('Booking Agent Referral Show loaded'); </script>
@stop 