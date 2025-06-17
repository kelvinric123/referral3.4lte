@extends('adminlte::page')

@section('title', 'Edit Referral')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Referral #{{ $referral->id }}</h1>
        <div>
            <a href="{{ route('admin.referrals.index') }}" class="btn btn-default mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.referrals.show', $referral->id) }}" class="btn btn-info mr-2">
                <i class="fas fa-eye"></i> View Only
            </a>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('admin.referrals.update', $referral->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                <div class="form-group">
                                    <label class="form-label"><strong>Name</strong></label>
                                    <input type="text" class="form-control @error('patient_name') is-invalid @enderror text-uppercase" name="patient_name" value="{{ old('patient_name', $referral->patient_name) }}" required style="text-transform: uppercase;">
                                    @error('patient_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label"><strong>ID Type</strong></label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="id_type" id="id_type_ic" value="ic" {{ old('id_type', $referral->id_type ?? 'ic') == 'ic' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="id_type_ic">Malaysian IC</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="id_type" id="id_type_passport" value="passport" {{ old('id_type', $referral->id_type ?? 'ic') == 'passport' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="id_type_passport">Passport</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" id="patient_id_label"><strong>IC Number</strong></label>
                                    <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id', $referral->patient_id) }}" required>
                                    <small class="form-text text-muted" id="patient_id_help">Malaysian IC format: YYMMDD-PB-###G</small>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label"><strong>Date of Birth</strong></label>
                                    <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob', $referral->patient_dob ? date('Y-m-d', strtotime($referral->patient_dob)) : '') }}" required>
                                    @error('patient_dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label"><strong>Age</strong></label>
                                    <input type="number" class="form-control @error('patient_age') is-invalid @enderror" id="patient_age" name="patient_age" value="{{ old('patient_age', $referral->patient_age ?? '') }}" min="0" max="150" required>
                                    @error('patient_age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><strong>Contact Number</strong></label>
                                    <input type="text" class="form-control @error('patient_contact') is-invalid @enderror" name="patient_contact" value="{{ old('patient_contact', $referral->patient_contact) }}" required>
                                    @error('patient_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label"><strong>Email</strong></label>
                                    <input type="email" class="form-control @error('patient_email') is-invalid @enderror" name="patient_email" value="{{ old('patient_email', $referral->patient_email) }}">
                                    @error('patient_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label"><strong>Address</strong></label>
                                    <textarea class="form-control @error('patient_address') is-invalid @enderror" name="patient_address" rows="3">{{ old('patient_address', $referral->patient_address) }}</textarea>
                                    @error('patient_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                        <div class="form-group">
                            <label class="form-label"><strong>Diagnosis/Condition</strong></label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" rows="3" required>{{ old('diagnosis', $referral->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Clinical History</strong></label>
                            <textarea class="form-control @error('clinical_history') is-invalid @enderror" name="clinical_history" rows="3">{{ old('clinical_history', $referral->clinical_history) }}</textarea>
                            @error('clinical_history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Additional Remarks</strong></label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" rows="3">{{ old('remarks', $referral->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                            <td>{{ $document->original_name }}</td>
                                            <td>{{ $document->type }}</td>
                                            <td>{{ $document->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.documents.download', $document->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-document" data-id="{{ $document->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
                        <div class="form-group">
                            <label for="documents"><strong>Upload Additional Documents</strong></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documents" name="documents[]" multiple>
                                    <label class="custom-file-label" for="documents">Choose files</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">You can upload multiple files. Allowed file types: PDF, DOC, DOCX, JPG, PNG. Max size: 10MB per file.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Hospital & Specialty -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-hospital mr-2"></i>
                            Hospital & Specialty
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><strong>Hospital</strong></label>
                            <select class="form-control select2 @error('hospital_id') is-invalid @enderror" id="hospital_id" name="hospital_id" required>
                                <option value="">Select Hospital</option>
                                @php
                                    $hospitals = \App\Models\Hospital::where('is_active', true)->get();
                                @endphp
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hospital_id', $referral->hospital_id) == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Specialty</strong></label>
                            <select class="form-control select2 @error('specialty_id') is-invalid @enderror" id="specialty_id" name="specialty_id" required>
                                <option value="">Select Specialty</option>
                                @php
                                    $specialties = \App\Models\Specialty::with('hospital')->where('is_active', true)->get();
                                @endphp
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" 
                                            data-hospital="{{ $specialty->hospital_id }}"
                                            {{ old('specialty_id', $referral->specialty_id) == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('specialty_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Consultant</strong></label>
                            <select class="form-control select2 @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                <option value="">Select Consultant</option>
                                @php
                                    $consultants = \App\Models\Consultant::with(['specialty', 'hospital'])->where('is_active', true)->get();
                                @endphp
                                @foreach($consultants as $consultant)
                                    <option value="{{ $consultant->id }}" 
                                            data-specialty="{{ $consultant->specialty_id }}"
                                            data-hospital="{{ $consultant->hospital_id }}"
                                            {{ old('consultant_id', $referral->consultant_id) == $consultant->id ? 'selected' : '' }}>
                                        {{ $consultant->name }} ({{ ucfirst($consultant->gender) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('consultant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <div class="form-group">
                            <label class="form-label"><strong>Referrer Type</strong></label>
                            <select class="form-control @error('referrer_type') is-invalid @enderror" id="referrer_type" name="referrer_type" required>
                                <option value="">Select Referrer Type</option>
                                <option value="GP" {{ old('referrer_type', $referral->referrer_type) == 'GP' ? 'selected' : '' }}>GP</option>
                                <option value="BookingAgent" {{ old('referrer_type', $referral->referrer_type) == 'BookingAgent' ? 'selected' : '' }}>Booking Agent</option>
                            </select>
                            @error('referrer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group gp-field" style="{{ old('referrer_type', $referral->referrer_type) == 'GP' ? '' : 'display: none;' }}">
                            <label class="form-label"><strong>GP</strong></label>
                            <select class="form-control select2 @error('gp_id') is-invalid @enderror" id="gp_id" name="gp_id">
                                <option value="">Select GP</option>
                                @php
                                    $gps = \App\Models\GP::where('is_active', true)->get();
                                @endphp
                                @foreach($gps as $gp)
                                    <option value="{{ $gp->id }}" {{ old('gp_id', $referral->gp_id) == $gp->id ? 'selected' : '' }}>
                                        {{ $gp->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gp_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group agent-field" style="{{ old('referrer_type', $referral->referrer_type) == 'BookingAgent' ? '' : 'display: none;' }}">
                            <label class="form-label"><strong>Booking Agent</strong></label>
                            <select class="form-control select2 @error('booking_agent_id') is-invalid @enderror" id="booking_agent_id" name="booking_agent_id">
                                <option value="">Select Booking Agent</option>
                                @php
                                    $bookingAgents = \App\Models\BookingAgent::where('is_active', true)->get();
                                @endphp
                                @foreach($bookingAgents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('booking_agent_id', $referral->booking_agent_id) == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('booking_agent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar mr-2"></i>
                            Appointment Details
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><strong>Preferred Date</strong></label>
                            <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" name="preferred_date" value="{{ old('preferred_date', $referral->preferred_date ? date('Y-m-d', strtotime($referral->preferred_date)) : '') }}">
                            @error('preferred_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Priority</strong></label>
                            <select class="form-control @error('priority') is-invalid @enderror" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="Normal" {{ old('priority', $referral->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Urgent" {{ old('priority', $referral->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="Emergency" {{ old('priority', $referral->priority) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><strong>Status</strong></label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                @if($referral->status == 'Pending')
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                @elseif($referral->status == 'Approved')
                                    <option value="Approved" selected>Approved</option>
                                    <option value="Completed">Completed</option>
                                    <option value="No Show">No Show</option>
                                @elseif(in_array($referral->status, ['Rejected', 'Completed', 'No Show']))
                                    <option value="{{ $referral->status }}" selected>{{ $referral->status }}</option>
                                @endif
                            </select>
                            <small class="form-text text-muted">
                                @if($referral->status == 'Pending')
                                    Pending referrals can be Approved or Rejected
                                @elseif($referral->status == 'Approved')
                                    Approved referrals can be marked as Completed or No Show
                                @elseif(in_array($referral->status, ['Rejected', 'Completed', 'No Show']))
                                    {{ $referral->status }} is a final status and cannot be changed
                                @endif
                            </small>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Previous Feedback Display -->
                @if($referral->admin_feedback && $referral->feedback_sent_at)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comment mr-2"></i>
                            Previous Feedback to {{ $referral->referrer_type }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <small><strong>Sent:</strong> {{ $referral->feedback_sent_at->format('d M Y, H:i') }}</small>
                            <div class="mt-2">{{ $referral->admin_feedback }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Status Timeline -->
                @include('admin.referrals.partials.timeline', ['referral' => $referral])

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-success btn-lg mr-2">
                            <i class="fas fa-save"></i> Update Referral
                        </button>
                        <a href="{{ route('admin.referrals.show', $referral->id) }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .form-label {
            margin-bottom: 5px;
            color: #333;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-lg {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Force patient name to uppercase
            $('input[name="patient_name"]').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Handle ID type change
            $('input[name="id_type"]').on('change', function() {
                const idType = $(this).val();
                
                if (idType === 'ic') {
                    $('#patient_id_label').html('<strong>IC Number</strong>');
                    $('#patient_id_help').text('Malaysian IC format: YYMMDD-PB-###G').show();
                    $('#patient_dob').prop('readonly', true);
                    $('#patient_age').prop('readonly', true);
                    
                    if ($('#patient_id').val()) {
                        calculateFromIC();
                    }
                } else {
                    $('#patient_id_label').html('<strong>Passport Number</strong>');
                    $('#patient_id_help').hide();
                    $('#patient_dob').prop('readonly', false);
                    $('#patient_age').prop('readonly', false);
                }
            });

            // Calculate DOB and age from Malaysian IC
            function calculateFromIC() {
                const icNumber = $('#patient_id').val().replace(/[^0-9]/g, '');
                
                if (icNumber.length >= 6) {
                    const yearPart = icNumber.substring(0, 2);
                    const monthPart = icNumber.substring(2, 4);
                    const dayPart = icNumber.substring(4, 6);
                    
                    const currentYear = new Date().getFullYear();
                    const century = parseInt(yearPart) > (currentYear % 100) ? 1900 : 2000;
                    const fullYear = century + parseInt(yearPart);
                    
                    const dob = new Date(fullYear, parseInt(monthPart) - 1, parseInt(dayPart));
                    const formattedDate = dob.toISOString().split('T')[0];
                    $('#patient_dob').val(formattedDate);
                    
                    const ageDate = new Date(Date.now() - dob.getTime());
                    const age = Math.abs(ageDate.getUTCFullYear() - 1970);
                    $('#patient_age').val(age);
                }
            }

            // IC input handler
            $('#patient_id').on('input', function() {
                const idType = $('input[name="id_type"]:checked').val();
                if (idType === 'ic') {
                    calculateFromIC();
                }
            });

            // DOB change handler for passport mode
            $('#patient_dob').on('change', function() {
                const idType = $('input[name="id_type"]:checked').val();
                if (idType === 'passport') {
                    const dob = new Date($(this).val());
                    if (!isNaN(dob)) {
                        const ageDate = new Date(Date.now() - dob.getTime());
                        const age = Math.abs(ageDate.getUTCFullYear() - 1970);
                        $('#patient_age').val(age);
                    }
                }
            });

            // Filter specialties by hospital
            $('#hospital_id').on('change', function() {
                const hospitalId = $(this).val();
                $('#specialty_id').val('');
                $('#consultant_id').val('');
                
                $('#specialty_id option').prop('disabled', true);
                
                if (hospitalId) {
                    $('#specialty_id option').each(function() {
                        if ($(this).val() === '' || $(this).data('hospital') == hospitalId) {
                            $(this).prop('disabled', false);
                        }
                    });
                } else {
                    $('#specialty_id option').prop('disabled', false);
                }
                
                filterConsultants();
            });

            // Filter consultants
            function filterConsultants() {
                const specialtyId = $('#specialty_id').val();
                const hospitalId = $('#hospital_id').val();
                
                $('#consultant_id option').show();
                
                $('#consultant_id option').each(function() {
                    if ($(this).val() === '') return;
                    
                    let match = true;
                    
                    if (hospitalId && $(this).data('hospital') != hospitalId) {
                        match = false;
                    }
                    
                    if (specialtyId && $(this).data('specialty') != specialtyId) {
                        match = false;
                    }
                    
                    if (!match) {
                        $(this).hide();
                    }
                });
            }
            
            $('#specialty_id').on('change', filterConsultants);

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            
            // Show/hide referrer fields
            $('#referrer_type').change(function() {
                var selectedValue = $(this).val();
                
                if (selectedValue === 'GP') {
                    $('.gp-field').show();
                    $('.agent-field').hide();
                    $('#booking_agent_id').val('');
                } else if (selectedValue === 'BookingAgent') {
                    $('.gp-field').hide();
                    $('.agent-field').show();
                    $('#gp_id').val('');
                } else {
                    $('.gp-field, .agent-field').hide();
                    $('#gp_id, #booking_agent_id').val('');
                }
            });
            
            // Handle file input display
            $(document).on('change', '.custom-file-input', function() {
                var fileCount = $(this)[0].files.length;
                var label = fileCount > 1 ? fileCount + ' files selected' : $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(label);
            });
            
            // Handle document deletion
            $('.delete-document').click(function() {
                if (confirm('Are you sure you want to delete this document?')) {
                    var documentId = $(this).data('id');
                    
                    $.ajax({
                        url: '/admin/documents/' + documentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            location.reload();
                        },
                        error: function() {
                            alert('Error deleting document');
                        }
                    });
                }
            });

            // Initialize ID type behavior on page load
            $('input[name="id_type"]:checked').trigger('change');
            
            // Initialize hospital change to filter specialties/consultants
            $('#hospital_id').trigger('change');
        });
    </script>
@stop 