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
                <a href="{{ route('hospital.referrals.index') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-arrow-left"></i> Back to Referrals
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('hospital.referrals.store') }}" method="POST" enctype="multipart/form-data">
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
                                <h3 class="card-title">Specialty Information</h3>
                            </div>
                            <div class="card-body">
                                <!-- Display hospital information but don't allow changes -->
                                <div class="form-group">
                                    <label>Hospital</label>
                                    <input type="text" class="form-control" value="{{ $hospital->name }}" readonly>
                                    <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
                                </div>

                                <div class="form-group">
                                    <label for="specialty_id">Specialty</label>
                                    <select class="form-control @error('specialty_id') is-invalid @enderror" id="specialty_id" name="specialty_id" required>
                                        <option value="">Select Specialty</option>
                                        @foreach($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
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
                                    <label for="consultant_id">Consultant</label>
                                    <select class="form-control @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" 
                                                    data-specialty="{{ $consultant->specialty_id }}"
                                                    data-gender="{{ $consultant->gender }}"
                                                    data-languages="{{ json_encode($consultant->languages ?? []) }}"
                                                    {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }} ({{ ucfirst($consultant->gender) }}, {{ implode(', ', $consultant->languages ?? []) }})
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
                                            @foreach($bookingAgents as $bookingAgent)
                                                <option value="{{ $bookingAgent->id }}" {{ old('booking_agent_id') == $bookingAgent->id ? 'selected' : '' }}>
                                                    {{ $bookingAgent->name }} - {{ $bookingAgent->company->name ?? 'N/A' }}
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
                                <h3 class="card-title">Referral Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="preferred_date">Preferred Date</label>
                                    <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ date('Y-m-d') }}" required>
                                    @error('preferred_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
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
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ old('status', 'Pending') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
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
                                    <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="3" required>{{ old('diagnosis') }}</textarea>
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
                                    <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="documents">Documents</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('documents.*') is-invalid @enderror" id="documents" name="documents[]" multiple>
                                        <label class="custom-file-label" for="documents">Choose files</label>
                                    </div>
                                    <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB each)</small>
                                    @error('documents.*')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Create Referral</button>
                        <a href="{{ route('hospital.referrals.index') }}" class="btn btn-default">Cancel</a>
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
            // Convert IC to Date of Birth
            $('#patient_id').on('change', function() {
                let ic = $(this).val();
                // Malaysian IC format: YYMMDD-PB-###G
                let regExp = /^(\d{2})(\d{2})(\d{2})/;
                let matches = ic.match(regExp);
                
                if (matches && matches.length === 4) {
                    let year = parseInt(matches[1]);
                    let month = parseInt(matches[2]);
                    let day = parseInt(matches[3]);
                    
                    // Determine century
                    if (year >= 0 && year <= 30) {
                        year = 2000 + year;
                    } else {
                        year = 1900 + year;
                    }
                    
                    let dob = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
                    $('#patient_dob').val(dob);
                    
                    // Calculate age
                    let today = new Date();
                    let birthDate = new Date(dob);
                    let age = today.getFullYear() - birthDate.getFullYear();
                    let m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    $('#patient_age').val(age + ' years');
                }
            });

            // Toggle referrer type sections
            $('#referrer_type').on('change', function() {
                let type = $(this).val();
                if (type === 'GP') {
                    $('#gp_section').removeClass('d-none');
                    $('#booking_agent_section').addClass('d-none');
                    $('#gp_id').prop('required', true);
                    $('#booking_agent_id').prop('required', false);
                } else if (type === 'BookingAgent') {
                    $('#gp_section').addClass('d-none');
                    $('#booking_agent_section').removeClass('d-none');
                    $('#gp_id').prop('required', false);
                    $('#booking_agent_id').prop('required', true);
                } else {
                    $('#gp_section').addClass('d-none');
                    $('#booking_agent_section').addClass('d-none');
                    $('#gp_id').prop('required', false);
                    $('#booking_agent_id').prop('required', false);
                }
            });

            // Filter consultants based on specialty and preferences
            $('#specialty_id, #consultant_gender, #consultant_language').on('change', function() {
                let specialtyId = $('#specialty_id').val();
                let gender = $('#consultant_gender').val();
                let language = $('#consultant_language').val();
                
                $('#consultant_id option').each(function() {
                    let $option = $(this);
                    let optionSpecialty = $option.data('specialty');
                    let optionGender = $option.data('gender');
                    let optionLanguages = $option.data('languages');
                    
                    // Skip the default "Select Consultant" option
                    if (!optionSpecialty) return true;
                    
                    let showOption = true;
                    
                    // Filter by specialty
                    if (specialtyId && optionSpecialty != specialtyId) {
                        showOption = false;
                    }
                    
                    // Filter by gender if specified
                    if (gender && optionGender != gender) {
                        showOption = false;
                    }
                    
                    // Filter by language if specified
                    if (language && optionLanguages && Array.isArray(optionLanguages)) {
                        if (!optionLanguages.includes(language)) {
                            showOption = false;
                        }
                    }
                    
                    if (showOption) {
                        $option.show();
                    } else {
                        $option.hide();
                    }
                });
                
                // Reset consultant selection if filtered
                if ($('#consultant_id option:selected').css('display') === 'none') {
                    $('#consultant_id').val('');
                }
            });

            // File input display selected files
            $('#documents').on('change', function() {
                let fileCount = this.files.length;
                $(this).next('.custom-file-label').html(fileCount + ' file(s) selected');
            });
        });
    </script>
@stop 