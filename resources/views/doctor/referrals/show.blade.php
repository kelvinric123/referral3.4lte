@extends('adminlte::page')

@section('title', 'Referral Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Referral Details</h1>
        <a href="{{ route('doctor.referrals.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Referrals
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Patient Information</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Patient Name</dt>
                        <dd class="col-sm-8">{{ $referral->patient_name }}</dd>
                        
                        <dt class="col-sm-4">Patient ID</dt>
                        <dd class="col-sm-8">{{ $referral->patient_id }}</dd>
                        
                        <dt class="col-sm-4">Date of Birth</dt>
                        <dd class="col-sm-8">{{ $referral->patient_dob->format('d/m/Y') }}</dd>
                        
                        <dt class="col-sm-4">Contact</dt>
                        <dd class="col-sm-8">{{ $referral->patient_contact }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Referral Status</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Status</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        @switch($referral->status)
                                            @case('Pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('Approved')
                                                <span class="badge badge-success">Approved</span>
                                                @break
                                            @case('Rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge badge-primary">Completed</span>
                                                @break
                                            @case('No Show')
                                                <span class="badge badge-secondary">No Show</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">{{ $referral->status }}</span>
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Priority</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        @switch($referral->priority)
                                            @case('Normal')
                                                <span class="badge badge-info">Normal</span>
                                                @break
                                            @case('Urgent')
                                                <span class="badge badge-warning">Urgent</span>
                                                @break
                                            @case('Emergency')
                                                <span class="badge badge-danger">Emergency</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $referral->priority }}</span>
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Date Created</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        {{ $referral->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Send Feedback Section -->
                    @if(in_array($referral->status, ['Approved', 'Completed', 'No Show']))
                        <div class="feedback-section mt-3">
                            <h6 class="text-muted mb-2">Send Feedback to Hospital:</h6>
                            
                            @if($referral->gp_feedback && $referral->gp_feedback_sent_at)
                                <div class="alert alert-info mb-2">
                                    <small><strong>Last Feedback Sent:</strong> {{ $referral->gp_feedback_sent_at->format('d M Y, H:i') }}</small>
                                    <div class="mt-1">{{ $referral->gp_feedback }}</div>
                                </div>
                            @endif
                            
                            <form action="{{ route('doctor.referrals.send-feedback', $referral->id) }}" method="POST" class="feedback-form">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control form-control-sm @error('gp_feedback') is-invalid @enderror" 
                                             name="gp_feedback" 
                                             rows="3" 
                                             placeholder="Share your feedback about the consultation, treatment outcome, or experience with the hospital/consultant..."
                                             required></textarea>
                                    @error('gp_feedback')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-paper-plane mr-1"></i> Send Feedback
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Admin Feedback Section -->
    @if($referral->admin_feedback && $referral->feedback_sent_at)
    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-comment-medical mr-2"></i>
                        Feedback from Hospital/Admin
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <small><strong>Feedback Received:</strong> {{ $referral->feedback_sent_at->format('d M Y, H:i') }}</small>
                        <div class="mt-2">{{ $referral->admin_feedback }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Referral Details</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Hospital</dt>
                        <dd class="col-sm-8">{{ $referral->hospital->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Specialty</dt>
                        <dd class="col-sm-8">{{ $referral->specialty->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Consultant</dt>
                        <dd class="col-sm-8">{{ $referral->consultant->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Preferred Date</dt>
                        <dd class="col-sm-8">{{ $referral->preferred_date->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Medical Information</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Diagnosis</dt>
                        <dd>{{ $referral->diagnosis }}</dd>
                        
                        @if($referral->clinical_history)
                            <dt>Clinical History</dt>
                            <dd>{{ $referral->clinical_history }}</dd>
                        @endif
                        
                        @if($referral->remarks)
                            <dt>Remarks</dt>
                            <dd>{{ $referral->remarks }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    @if($referral->documents && $referral->documents->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Documents</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($referral->documents as $document)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    {{ $document->original_name }}
                                </div>
                                <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <style>
        .feedback-section {
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
            margin-top: 15px;
        }
        .feedback-form textarea {
            resize: vertical;
            min-height: 80px;
        }
        .alert-info {
            border-left: 4px solid #17a2b8;
            margin-bottom: 0;
        }
        .card-info .card-header {
            background-color: #d1ecf1;
            border-bottom: 1px solid #bee5eb;
        }
    </style>
@stop 