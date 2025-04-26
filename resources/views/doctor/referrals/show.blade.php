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
                </div>
            </div>
        </div>
    </div>
    
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