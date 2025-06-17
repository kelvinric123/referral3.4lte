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
                                    @if($referral->patient_email ?? false)
                                        <i class="fas fa-envelope mr-1 text-muted"></i>
                                        {{ $referral->patient_email }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </dd>
                                
                                <dt>Address</dt>
                                <dd>
                                    @if($referral->patient_address ?? false)
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file mr-2"></i>
                        Documents
                    </h3>
                </div>
                <div class="card-body">
                    @if($referral->documents && count($referral->documents) > 0)
                        <div class="table-responsive mb-3">
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
                    @else
                        <p class="text-muted">No documents uploaded yet.</p>
                    @endif

                    <!-- Document Upload Form -->
                    <form action="{{ route('admin.referrals.upload-documents', $referral->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="documents">Upload Documents</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documents" name="documents[]" multiple required>
                                    <label class="custom-file-label" for="documents">Choose files</label>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">You can upload multiple files. Allowed file types: PDF, DOC, DOCX, JPG, PNG. Max size: 10MB per file.</small>
                        </div>
                    </form>
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
                                'Completed' => 'primary'
                            ][$referral->status] ?? 'secondary';
                            
                            $statusIcon = [
                                'Pending' => 'fas fa-clock',
                                'Approved' => 'fas fa-check-circle',
                                'Rejected' => 'fas fa-times-circle',
                                'No Show' => 'fas fa-exclamation-triangle',
                                'Completed' => 'fas fa-check-double'
                            ][$referral->status] ?? 'fas fa-circle';
                        @endphp
                        <div class="alert alert-{{ $statusClass }} mb-3" style="border-left: 5px solid;">
                            <h4 class="alert-heading">
                                <i class="{{ $statusIcon }} mr-2"></i>
                                Current Status: {{ $referral->status }}
                            </h4>
                            <p class="mb-0">
                                <small class="text-muted">
                                    Last updated: {{ $referral->updated_at->format('d M Y, H:i') }}
                                </small>
                            </p>
                        </div>
                        
                        <!-- Quick Status Update (if current status allows) -->
                        @if(in_array($referral->status, ['Pending', 'Approved']))
                            <div class="status-actions mb-3">
                                <h6 class="text-muted mb-2">Quick Actions:</h6>
                                <form action="{{ route('admin.referrals.update-status', $referral->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @if($referral->status == 'Pending')
                                        <button type="submit" name="status" value="Approved" class="btn btn-success btn-sm mr-2" onclick="return confirm('Approve this referral?')">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                        <button type="submit" name="status" value="Rejected" class="btn btn-danger btn-sm" onclick="return confirm('Reject this referral?')">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    @elseif($referral->status == 'Approved')
                                        <button type="submit" name="status" value="Completed" class="btn btn-primary btn-sm mr-2" onclick="return confirm('Mark as completed?')">
                                            <i class="fas fa-check-double mr-1"></i> Complete
                                        </button>
                                        <button type="submit" name="status" value="No Show" class="btn btn-warning btn-sm" onclick="return confirm('Mark as no show?')">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> No Show
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Send Feedback Section -->
                    <div class="feedback-section mb-3">
                        <h6 class="text-muted mb-2">Send Feedback to {{ $referral->referrer_type }}:</h6>
                        
                        @if($referral->admin_feedback && $referral->feedback_sent_at)
                            <div class="alert alert-info mb-2">
                                <small><strong>Last Feedback Sent:</strong> {{ $referral->feedback_sent_at->format('d M Y, H:i') }}</small>
                                <div class="mt-1">{{ $referral->admin_feedback }}</div>
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.referrals.send-feedback', $referral->id) }}" method="POST" class="feedback-form">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control form-control-sm @error('admin_feedback') is-invalid @enderror" 
                                         name="admin_feedback" 
                                         rows="3" 
                                         placeholder="Type your feedback message here..."
                                         required></textarea>
                                @error('admin_feedback')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane mr-1"></i> Send Feedback
                            </button>
                        </form>
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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hospital mr-2"></i>
                        Hospital & Specialty
                    </h3>
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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-md mr-2"></i>
                        Referrer Information
                    </h3>
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

            <!-- Status Timeline -->
            @include('admin.referrals.partials.timeline', ['referral' => $referral])
        </div>
    </div>


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
        .alert {
            border-radius: 8px;
        }
        .status-actions .btn {
            border-radius: 6px;
        }
        .feedback-section {
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }
        .feedback-form textarea {
            resize: vertical;
            min-height: 80px;
        }
        .alert-info {
            border-left: 4px solid #17a2b8;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Handle file input display
            $(document).on('change', '.custom-file-input', function() {
                var fileCount = $(this)[0].files.length;
                var label = fileCount > 1 ? fileCount + ' files selected' : $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(label);
            });
        });
    </script>
@stop 