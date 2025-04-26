@extends('adminlte::page')

@section('title', 'Create Referral')

@section('content_header')
    <h1>Create New Referral</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('doctor.referrals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Patient Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="patient_name">Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" id="patient_name" class="form-control @error('patient_name') is-invalid @enderror text-uppercase" value="{{ old('patient_name') }}" required style="text-transform: uppercase;">
                                    @error('patient_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_id">IC/Passport Number <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" value="{{ old('patient_id') }}" required>
                                    <small class="form-text text-muted">Malaysian IC format: YYMMDD-PB-###G</small>
                                    @error('patient_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_dob">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="patient_dob" id="patient_dob" class="form-control @error('patient_dob') is-invalid @enderror" value="{{ old('patient_dob') }}" readonly>
                                    @error('patient_dob')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_age">Age</label>
                                    <input type="text" class="form-control" id="patient_age" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_contact">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_contact" id="patient_contact" class="form-control @error('patient_contact') is-invalid @enderror" value="{{ old('patient_contact') }}" required>
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
                                    <label for="hospital_id">Hospital <span class="text-danger">*</span></label>
                                    <select name="hospital_id" id="hospital_id" class="form-control @error('hospital_id') is-invalid @enderror" required>
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
                                    <label for="specialty_id">Specialty <span class="text-danger">*</span></label>
                                    <select name="specialty_id" id="specialty_id" class="form-control @error('specialty_id') is-invalid @enderror" required>
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
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="consultant_id">Consultant <span class="text-danger">*</span></label>
                                    <select name="consultant_id" id="consultant_id" class="form-control @error('consultant_id') is-invalid @enderror" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" 
                                                data-specialty="{{ $consultant->specialty_id }}"
                                                data-hospital="{{ $consultant->hospital_id }}"
                                                data-gender="{{ $consultant->gender }}"
                                                data-languages="{{ json_encode($consultant->languages ?? []) }}"
                                                {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }} ({{ ucfirst($consultant->gender ?? 'Unknown') }}, {{ implode(', ', $consultant->languages ?? ['English']) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('consultant_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="preferred_date">Preferred Date <span class="text-danger">*</span></label>
                                    <input type="date" name="preferred_date" id="preferred_date" class="form-control @error('preferred_date') is-invalid @enderror" value="{{ old('preferred_date') }}" required>
                                    @error('preferred_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                                        <option value="Normal" {{ old('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="Emergency" {{ old('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                    </select>
                                    @error('priority')
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
                                    <label for="diagnosis">Diagnosis/Condition <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}" required>
                                    @error('diagnosis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="clinical_history">Clinical History</label>
                                    <textarea name="clinical_history" id="clinical_history" rows="3" class="form-control @error('clinical_history') is-invalid @enderror">{{ old('clinical_history') }}</textarea>
                                    @error('clinical_history')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="remarks">Additional Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
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
                            <a href="{{ route('doctor.referrals.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Referrals
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Create Referral
                            </button>
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
            
            // First show all options
            $('#consultant_id option').show();
            
            // Then hide filtered-out options
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
                    if (!consultantLanguages || !consultantLanguages.includes(language)) {
                        match = false;
                    }
                }
                
                if (!match) {
                    $(this).hide();
                }
            });
        }
        
        // Bind events for consultant filtering
        $('#specialty_id, #consultant_gender, #consultant_language').on('change', function() {
            filterConsultants();
        });
        
        // Trigger IC input if there's a value already (for form redisplays)
        if ($('#patient_id').val()) {
            $('#patient_id').trigger('input');
        }
        
        // Trigger change events to initialize form state
        $('#hospital_id').trigger('change');
    });
</script>
@stop 