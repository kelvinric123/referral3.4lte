@extends('adminlte::page')

@section('title', 'Create New Referral')

@section('content_header')
    <h1>Create New Referral</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Referral Information</h3>
            <div class="card-tools">
                <a href="{{ route('admin.referrals.index') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-arrow-left"></i> Back to Referrals
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.referrals.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Patient Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="patient_name">Patient Name</label>
                                    <input type="text" class="form-control @error('patient_name') is-invalid @enderror text-uppercase" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required style="text-transform: uppercase;">
                                    @error('patient_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_id">IC/Passport Number</label>
                                    <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id') }}" required>
                                    <small class="form-text text-muted">Malaysian IC format: YYMMDD-PB-###G</small>
                                    @error('patient_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_dob">Date of Birth</label>
                                    <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob') }}" readonly>
                                    @error('patient_dob')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_age">Age</label>
                                    <input type="text" class="form-control" id="patient_age" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="patient_contact">Contact Number</label>
                                    <input type="text" class="form-control @error('patient_contact') is-invalid @enderror" id="patient_contact" name="patient_contact" value="{{ old('patient_contact') }}" required>
                                    @error('patient_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Hospital & Specialty Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="hospital_id">Hospital</label>
                                    <select class="form-control @error('hospital_id') is-invalid @enderror" id="hospital_id" name="hospital_id" required>
                                        <option value="">Select Hospital</option>
                                        @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                                {{ $hospital->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hospital_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="specialty_id">Specialty</label>
                                    <select class="form-control @error('specialty_id') is-invalid @enderror" id="specialty_id" name="specialty_id" required>
                                        <option value="">Select Specialty</option>
                                        @foreach($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" 
                                                data-hospital="{{ $specialty->hospital_id }}"
                                                {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                                {{ $specialty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialty_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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

                                <div class="form-group">
                                    <label for="consultant_id">Consultant</label>
                                    <select class="form-control @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" 
                                                    data-specialty="{{ $consultant->specialty_id }}"
                                                    data-hospital="{{ $consultant->hospital_id }}"
                                                    data-gender="{{ $consultant->gender }}"
                                                    data-languages="{{ json_encode($consultant->languages) }}"
                                                    {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }} ({{ ucfirst($consultant->gender) }}, {{ implode(', ', $consultant->languages) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('consultant_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Referrer Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="referrer_type">Referrer Type</label>
                                    <select class="form-control @error('referrer_type') is-invalid @enderror" id="referrer_type" name="referrer_type" required>
                                        <option value="">Select Referrer Type</option>
                                        <option value="GP" {{ old('referrer_type') == 'GP' ? 'selected' : '' }}>GP</option>
                                        <option value="BookingAgent" {{ old('referrer_type') == 'BookingAgent' ? 'selected' : '' }}>Booking Agent</option>
                                    </select>
                                    @error('referrer_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div id="gp_section" class="{{ old('referrer_type') == 'GP' ? '' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="gp_id">GP</label>
                                        <select class="form-control @error('gp_id') is-invalid @enderror" id="gp_id" name="gp_id" {{ old('referrer_type') == 'GP' ? 'required' : '' }}>
                                            <option value="">Select GP</option>
                                            @foreach($gps as $gp)
                                                <option value="{{ $gp->id }}" {{ old('gp_id') == $gp->id ? 'selected' : '' }}>
                                                    {{ $gp->name }} - {{ $gp->clinic->name ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('gp_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="booking_agent_section" class="{{ old('referrer_type') == 'BookingAgent' ? '' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="booking_agent_id">Booking Agent</label>
                                        <select class="form-control @error('booking_agent_id') is-invalid @enderror" id="booking_agent_id" name="booking_agent_id" {{ old('referrer_type') == 'BookingAgent' ? 'required' : '' }}>
                                            <option value="">Select Booking Agent</option>
                                            @foreach($bookingAgents as $agent)
                                                <option value="{{ $agent->id }}" {{ old('booking_agent_id') == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }} - {{ $agent->company->name ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('booking_agent_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Appointment Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="preferred_date">Preferred Date</label>
                                    <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}">
                                    @error('preferred_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="Normal" {{ old('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="Emergency" {{ old('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                    </select>
                                    @error('priority')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Medical Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis/Condition</label>
                                    <input type="text" class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}" required>
                                    @error('diagnosis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="clinical_history">Clinical History</label>
                                    <textarea class="form-control @error('clinical_history') is-invalid @enderror" id="clinical_history" name="clinical_history" rows="3">{{ old('clinical_history') }}</textarea>
                                    @error('clinical_history')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="remarks">Additional Remarks</label>
                                    <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.referrals.index') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Referral</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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

            // Toggle referrer sections
            $('#referrer_type').on('change', function() {
                var selectedType = $(this).val();
                
                if (selectedType === 'GP') {
                    $('#gp_section').removeClass('d-none');
                    $('#booking_agent_section').addClass('d-none');
                    $('#gp_id').prop('required', true);
                    $('#booking_agent_id').prop('required', false);
                } else if (selectedType === 'BookingAgent') {
                    $('#booking_agent_section').removeClass('d-none');
                    $('#gp_section').addClass('d-none');
                    $('#booking_agent_id').prop('required', true);
                    $('#gp_id').prop('required', false);
                } else {
                    $('#gp_section').addClass('d-none');
                    $('#booking_agent_section').addClass('d-none');
                    $('#gp_id').prop('required', false);
                    $('#booking_agent_id').prop('required', false);
                }
            });

            // Trigger change events to initialize form state
            $('#referrer_type').trigger('change');
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
            
            // Trigger IC input if there's a value already (for form redisplays)
            if ($('#patient_id').val()) {
                $('#patient_id').trigger('input');
            }
        });
    </script>
@stop 