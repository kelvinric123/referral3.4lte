@extends('adminlte::page')

@section('title', 'View Referral')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Referral #{{ $referral->id }}</h1>
        <div>
            <a href="{{ route('hospital.referrals.index') }}" class="btn btn-default mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('hospital.referrals.edit', $referral->id) }}" class="btn btn-primary">
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
                                <dt>Contact</dt>
                                <dd>{{ $referral->patient_contact ?? 'N/A' }}</dd>
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
                                    <td>{{ $document->original_name }}</td>
                                    <td>{{ $document->type }}</td>
                                    <td>{{ $document->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('hospital.documents.download', $document->id) }}" class="btn btn-sm btn-info">
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
                                'Pending' => 'warning',
                                'Approved' => 'success',
                                'Rejected' => 'danger',
                                'No Show' => 'info',
                                'Completed' => 'secondary'
                            ][$referral->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $statusClass }} p-3" style="font-size: 1.2rem;">
                            {{ $referral->status }}
                        </span>
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

            <!-- Specialty & Consultant -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Specialty & Consultant</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Hospital</dt>
                        <dd>{{ $hospital->name }}</dd>
                        
                        <dt>Specialty</dt>
                        <dd>{{ $referral->specialty->name ?? 'N/A' }}</dd>
                        
                        <dt>Consultant</dt>
                        @if($referral->consultant)
                            <dd>
                                {{ $referral->consultant->name }}
                                <div class="small text-muted">
                                    {{ ucfirst($referral->consultant->gender) }} | 
                                    {{ implode(', ', $referral->consultant->languages ?? []) }}
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
                            
                            <dt>GP Clinic</dt>
                            <dd>{{ $referral->gp->clinic->name ?? 'N/A' }}</dd>
                            
                            <dt>Contact</dt>
                            <dd>{{ $referral->gp->phone ?? 'N/A' }}</dd>
                        @elseif($referral->referrer_type == 'BookingAgent' && $referral->bookingAgent)
                            <dt>Booking Agent</dt>
                            <dd>{{ $referral->bookingAgent->name }}</dd>
                            
                            <dt>Company</dt>
                            <dd>{{ $referral->bookingAgent->company->name ?? 'N/A' }}</dd>
                            
                            <dt>Contact</dt>
                            <dd>{{ $referral->bookingAgent->phone ?? 'N/A' }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop 