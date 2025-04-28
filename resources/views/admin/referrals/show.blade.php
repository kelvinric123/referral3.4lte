@extends('adminlte::page')

@section('title', 'View Referral')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Referral #{{ $referral->id }}</h1>
        <div>
            <a href="{{ route('admin.referrals.index') }}" class="btn btn-default mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.referrals.edit', $referral->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Referral
            </a>
        </div>
    </div>
@stop

@section('content')
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
                                
                                <dt>Patient ID</dt>
                                <dd>{{ $referral->patient_id }}</dd>
                                
                                <dt>Date of Birth</dt>
                                <dd>{{ $referral->patient_dob ? date('d M Y', strtotime($referral->patient_dob)) : 'N/A' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Phone Number</dt>
                                <dd>{{ $referral->patient_phone ?? 'N/A' }}</dd>
                                
                                <dt>Email</dt>
                                <dd>{{ $referral->patient_email ?? 'N/A' }}</dd>
                                
                                <dt>Address</dt>
                                <dd>{{ $referral->patient_address ?? 'N/A' }}</dd>
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
                    <div class="row">
                        <div class="col-md-12">
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
            </div>

            <!-- Documents -->
            @if($referral->documents && count($referral->documents) > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file mr-2"></i>
                        Documents
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referral->documents as $document)
                                <tr>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->type }}</td>
                                    <td>{{ $document->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.documents.download', $document->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Referral Status -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Referral Status</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @php
                            $statusClass = [
                                'Pending' => 'secondary',
                                'Approved' => 'success',
                                'Rejected' => 'danger',
                                'No Show' => 'warning',
                                'Completed' => 'primary'
                            ][$referral->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $statusClass }} p-3" style="font-size: 1.2rem;">
                            {{ $referral->status }}
                        </span>
                    </div>
                    
                    <div class="status-flow mb-3">
                        <h6 class="text-muted">Status Flow:</h6>
                        <ul class="list-unstyled">
                            <li class="{{ $referral->status == 'Pending' ? 'font-weight-bold text-secondary' : '' }}">
                                <i class="fas fa-circle {{ $referral->status == 'Pending' ? 'text-secondary' : 'text-muted' }} mr-2"></i>Pending
                            </li>
                            <li class="ml-3 {{ $referral->status == 'Approved' ? 'font-weight-bold text-success' : '' }}">
                                <i class="fas fa-arrow-right text-muted mr-2"></i>
                                <i class="fas fa-circle {{ $referral->status == 'Approved' ? 'text-success' : 'text-muted' }} mr-2"></i>Approved
                            </li>
                            <li class="ml-5 {{ $referral->status == 'Completed' ? 'font-weight-bold text-primary' : '' }}">
                                <i class="fas fa-arrow-right text-muted mr-2"></i>
                                <i class="fas fa-circle {{ $referral->status == 'Completed' ? 'text-primary' : 'text-muted' }} mr-2"></i>Completed
                            </li>
                            <li class="ml-5 {{ $referral->status == 'No Show' ? 'font-weight-bold text-warning' : '' }}">
                                <i class="fas fa-arrow-right text-muted mr-2"></i>
                                <i class="fas fa-circle {{ $referral->status == 'No Show' ? 'text-warning' : 'text-muted' }} mr-2"></i>No Show
                            </li>
                            <li class="ml-3 {{ $referral->status == 'Rejected' ? 'font-weight-bold text-danger' : '' }}">
                                <i class="fas fa-arrow-right text-muted mr-2"></i>
                                <i class="fas fa-circle {{ $referral->status == 'Rejected' ? 'text-danger' : 'text-muted' }} mr-2"></i>Rejected
                            </li>
                        </ul>
                    </div>
                    
                    <dl>
                        <dt>Referral Date</dt>
                        <dd>{{ $referral->created_at->format('d M Y') }}</dd>
                        
                        <dt>Preferred Date</dt>
                        <dd>{{ $referral->preferred_date ? date('d M Y', strtotime($referral->preferred_date)) : 'Not specified' }}</dd>
                        
                        <dt>Priority</dt>
                        <dd>
                            @php
                                $priorityClass = [
                                    'Normal' => 'secondary',
                                    'Urgent' => 'warning',
                                    'Emergency' => 'danger'
                                ][$referral->priority] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $priorityClass }}">{{ $referral->priority }}</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Hospital & Specialty -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Hospital & Specialty</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Hospital</dt>
                        <dd>{{ $referral->hospital->name ?? 'N/A' }}</dd>
                        
                        <dt>Specialty</dt>
                        <dd>{{ $referral->specialty->name ?? 'N/A' }}</dd>
                        
                        <dt>Consultant</dt>
                        @if($referral->consultant)
                            <dd>
                                {{ $referral->consultant->name }}
                                <div class="small text-muted">
                                    {{ ucfirst($referral->consultant->gender) }} | 
                                    {{ implode(', ', $referral->consultant->languages) }}
                                </div>
                            </dd>
                        @else
                            <dd>N/A</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Referrer Information -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Referrer Information</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Referrer Type</dt>
                        <dd>{{ $referral->referrer_type }}</dd>
                        
                        @if($referral->referrer_type == 'GP' && $referral->gp)
                            <dt>GP Name</dt>
                            <dd>{{ $referral->gp->name }}</dd>
                            
                            @if($referral->gp->clinic)
                                <dt>GP Clinic</dt>
                                <dd>{{ $referral->gp->clinic->name }}</dd>
                            @endif
                        @elseif($referral->referrer_type == 'BookingAgent' && $referral->bookingAgent)
                            <dt>Booking Agent</dt>
                            <dd>{{ $referral->bookingAgent->name }}</dd>
                            
                            @if($referral->bookingAgent->company)
                                <dt>Company</dt>
                                <dd>{{ $referral->bookingAgent->company->name }}</dd>
                            @endif
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Status History -->
    @if(isset($referral->status_history) && count($referral->status_history) > 0)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Status History
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($referral->status_history as $history)
                        <div>
                            <i class="fas fa-circle bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="fas fa-clock"></i> 
                                    {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') }}
                                </span>
                                <h3 class="timeline-header">
                                    Status changed to <strong>{{ $history->status }}</strong>
                                </h3>
                                <div class="timeline-body">
                                    {{ $history->remarks ?? 'No additional remarks' }}
                                </div>
                                <div class="timeline-footer">
                                    <small class="text-muted">By: {{ $history->user->name ?? 'System' }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <style>
        dt {
            font-weight: 700;
            margin-top: 10px;
        }
        dd {
            margin-bottom: 8px;
            padding-left: 10px;
        }
        .card-header.bg-primary {
            color: white;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Any client-side functionality can go here
        });
    </script>
@stop 