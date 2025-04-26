@extends('adminlte::page')

@section('title', 'Edit Referral')

@section('content_header')
    <h1>Edit Referral #{{ $referral->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Referral Information</h3>
        </div>
        <form action="{{ route('admin.referrals.update', $referral->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <h4>Patient Information</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="patient_name">Patient Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('patient_name') is-invalid @enderror text-uppercase" id="patient_name" name="patient_name" value="{{ old('patient_name', $referral->patient_name) }}" required style="text-transform: uppercase;">
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="patient_id">Patient ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id', $referral->patient_id) }}" required>
                            <small class="form-text text-muted">Malaysian IC format: YYMMDD-PB-###G</small>
                            @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="patient_dob">Date of Birth</label>
                            <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob', $referral->patient_dob ? date('Y-m-d', strtotime($referral->patient_dob)) : '') }}" readonly>
                            @error('patient_dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patient_age">Age</label>
                            <input type="text" class="form-control" id="patient_age" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patient_phone">Phone Number</label>
                            <input type="text" class="form-control @error('patient_phone') is-invalid @enderror" id="patient_phone" name="patient_phone" value="{{ old('patient_phone', $referral->patient_phone) }}">
                            @error('patient_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patient_email">Email</label>
                            <input type="email" class="form-control @error('patient_email') is-invalid @enderror" id="patient_email" name="patient_email" value="{{ old('patient_email', $referral->patient_email) }}">
                            @error('patient_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="patient_address">Address</label>
                            <textarea class="form-control @error('patient_address') is-invalid @enderror" id="patient_address" name="patient_address" rows="2">{{ old('patient_address', $referral->patient_address) }}</textarea>
                            @error('patient_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Hospital & Specialty</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hospital_id">Hospital <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('hospital_id') is-invalid @enderror" id="hospital_id" name="hospital_id" required>
                                <option value="">Select Hospital</option>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialty_id">Specialty <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('specialty_id') is-invalid @enderror" id="specialty_id" name="specialty_id" required>
                                <option value="">Select Specialty</option>
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="consultant_gender">Preferred Gender</label>
                            <select class="form-control" id="consultant_gender">
                                <option value="">Any Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="consultant_language">Preferred Language</label>
                            <select class="form-control" id="consultant_language">
                                <option value="">Any Language</option>
                                <option value="English">English</option>
                                <option value="Malay">Malay</option>
                                <option value="Mandarin">Mandarin</option>
                                <option value="Tamil">Tamil</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Arabic">Arabic</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Korean">Korean</option>
                                <option value="French">French</option>
                                <option value="German">German</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="consultant_id">Consultant <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                <option value="">Select Consultant</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{ $consultant->id }}" 
                                            data-specialty="{{ $consultant->specialty_id }}"
                                            data-hospital="{{ $consultant->hospital_id }}"
                                            data-gender="{{ $consultant->gender }}"
                                            data-languages="{{ json_encode($consultant->languages) }}"
                                            {{ old('consultant_id', $referral->consultant_id) == $consultant->id ? 'selected' : '' }}>
                                        {{ $consultant->name }} ({{ ucfirst($consultant->gender) }}, {{ implode(', ', $consultant->languages) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('consultant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Referrer Information</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="referrer_type">Referrer Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('referrer_type') is-invalid @enderror" id="referrer_type" name="referrer_type" required>
                                <option value="">Select Referrer Type</option>
                                <option value="GP" {{ old('referrer_type', $referral->referrer_type) == 'GP' ? 'selected' : '' }}>GP</option>
                                <option value="BookingAgent" {{ old('referrer_type', $referral->referrer_type) == 'BookingAgent' ? 'selected' : '' }}>Booking Agent</option>
                            </select>
                            @error('referrer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 gp-field" style="{{ old('referrer_type', $referral->referrer_type) == 'GP' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="gp_id">GP <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('gp_id') is-invalid @enderror" id="gp_id" name="gp_id">
                                <option value="">Select GP</option>
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
                    </div>
                    <div class="col-md-6 agent-field" style="{{ old('referrer_type', $referral->referrer_type) == 'BookingAgent' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="booking_agent_id">Booking Agent <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('booking_agent_id') is-invalid @enderror" id="booking_agent_id" name="booking_agent_id">
                                <option value="">Select Booking Agent</option>
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

                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Appointment Details</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="preferred_date">Preferred Date</label>
                            <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" value="{{ old('preferred_date', $referral->preferred_date ? date('Y-m-d', strtotime($referral->preferred_date)) : '') }}">
                            @error('preferred_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="priority">Priority <span class="text-danger">*</span></label>
                            <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="Normal" {{ old('priority', $referral->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Urgent" {{ old('priority', $referral->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="Emergency" {{ old('priority', $referral->priority) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Pending" {{ old('status', $referral->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ old('status', $referral->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ old('status', $referral->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Medical Information</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="medical_condition">Medical Condition <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('medical_condition') is-invalid @enderror" id="medical_condition" name="medical_condition" rows="3" required>{{ old('medical_condition', $referral->medical_condition) }}</textarea>
                            @error('medical_condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $referral->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="documents">Documents</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documents" name="documents[]" multiple>
                                    <label class="custom-file-label" for="documents">Choose files</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">You can upload multiple files. Allowed file types: PDF, DOC, DOCX, JPG, PNG.</small>
                            @error('documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($referral->documents && count($referral->documents) > 0)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label>Current Documents</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
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
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.documents.download', $document->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger delete-document" data-id="{{ $document->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
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
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Referral</button>
                <a href="{{ route('admin.referrals.show', $referral->id) }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Force patient name to uppercase
            $('#patient_name').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Calculate DOB and age from Malaysian IC
            $('#patient_id').on('input', function() {
                const icNumber = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
                
                // Malaysian IC format: YYMMDD-PB-###G (we need the first 6 digits)
                if (icNumber.length >= 6) {
                    const yearPart = icNumber.substring(0, 2);
                    const monthPart = icNumber.substring(2, 4);
                    const dayPart = icNumber.substring(4, 6);
                    
                    // Determine century based on year digits
                    const currentYear = new Date().getFullYear();
                    const century = parseInt(yearPart) > (currentYear % 100) ? 1900 : 2000;
                    const fullYear = century + parseInt(yearPart);
                    
                    // Create date object with full year, month (0-indexed), and day
                    const dob = new Date(fullYear, parseInt(monthPart) - 1, parseInt(dayPart));
                    
                    // Format date for input field (YYYY-MM-DD)
                    const formattedDate = dob.toISOString().split('T')[0];
                    $('#patient_dob').val(formattedDate);
                    
                    // Calculate age
                    const ageDate = new Date(Date.now() - dob.getTime());
                    const age = Math.abs(ageDate.getUTCFullYear() - 1970);
                    $('#patient_age').val(age + ' years');
                } else {
                    $('#patient_dob').val('');
                    $('#patient_age').val('');
                }
            });

            // Filter specialties by hospital
            $('#hospital_id').on('change', function() {
                const hospitalId = $(this).val();
                
                // Reset specialty and consultant selections
                $('#specialty_id').val('');
                $('#consultant_id').val('');
                
                // Disable all specialties first
                $('#specialty_id option').prop('disabled', true);
                
                // Enable relevant specialties
                if (hospitalId) {
                    $('#specialty_id option').each(function() {
                        if ($(this).val() === '' || $(this).data('hospital') == hospitalId) {
                            $(this).prop('disabled', false);
                        }
                    });
                } else {
                    // If no hospital selected, enable all specialties
                    $('#specialty_id option').prop('disabled', false);
                }
                
                // Update consultants based on current filters
                filterConsultants();
            });

            // Filter consultants by specialty, gender and language
            function filterConsultants() {
                const specialtyId = $('#specialty_id').val();
                const hospitalId = $('#hospital_id').val();
                const gender = $('#consultant_gender').val();
                const language = $('#consultant_language').val();
                
                // Store current selection
                const currentConsultant = $('#consultant_id').val();
                
                // First show all options
                $('#consultant_id option').show();
                
                // Then hide filtered-out options instead of disabling them
                $('#consultant_id option').each(function() {
                    if ($(this).val() === '') {
                        return; // Skip the placeholder option
                    }
                    
                    let match = true;
                    
                    // Hospital filter
                    if (hospitalId && $(this).data('hospital') != hospitalId) {
                        match = false;
                    }
                    
                    // Specialty filter
                    if (specialtyId && $(this).data('specialty') != specialtyId) {
                        match = false;
                    }
                    
                    // Gender filter
                    if (gender && $(this).data('gender') != gender) {
                        match = false;
                    }
                    
                    // Language filter
                    if (language) {
                        const consultantLanguages = $(this).data('languages');
                        if (!consultantLanguages.includes(language)) {
                            match = false;
                        }
                    }
                    
                    if (!match) {
                        $(this).hide();
                    }
                });
                
                // Refresh select2 to apply the changes
                $('#consultant_id').select2('destroy').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
                
                // Restore selection if the option is still available
                if (currentConsultant && $('#consultant_id option[value="' + currentConsultant + '"]:visible').length) {
                    $('#consultant_id').val(currentConsultant).trigger('change.select2');
                }
            }
            
            // Bind events for consultant filtering
            $('#specialty_id, #consultant_gender, #consultant_language').on('change', function() {
                filterConsultants();
            });

            // Trigger IC input if there's a value already (to calculate age on page load)
            if ($('#patient_id').val()) {
                $('#patient_id').trigger('input');
            }

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            
            // Show/hide referrer fields based on referrer type
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
                        }
                    });
                }
            });
            
            // Initialize form by triggering hospital change
            $('#hospital_id').trigger('change');
            
            // If a consultant is already selected on page load, set filter values
            if ($('#consultant_id').val()) {
                const selectedOption = $('#consultant_id option:selected');
                if (selectedOption.length) {
                    // Pre-select gender filter if needed
                    const gender = selectedOption.data('gender');
                    if (gender) {
                        $('#consultant_gender').val(gender);
                    }
                    
                    // Don't pre-select language as there may be multiple
                }
            }
        });
    </script>
@stop 