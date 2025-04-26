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
                                    <input type="text" class="form-control @error('patient_name') is-invalid @enderror" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required>
                                    @error('patient_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_id">IC/Passport Number</label>
                                    <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id') }}" required>
                                    @error('patient_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_dob">Date of Birth</label>
                                    <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob') }}">
                                    @error('patient_dob')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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
                                            <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                                {{ $specialty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialty_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="consultant_id">Consultant</label>
                                    <select class="form-control @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" 
                                                    data-specialty="{{ $consultant->specialty_id }}"
                                                    {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}
                                                    {{ old('specialty_id') && old('specialty_id') != $consultant->specialty_id ? 'disabled' : '' }}>
                                                {{ $consultant->name }}
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

            // Filter consultants by specialty
            $('#specialty_id').on('change', function() {
                var specialtyId = $(this).val();
                
                // Enable all consultants first
                $('#consultant_id option').prop('disabled', false);
                
                // If a specialty is selected, disable consultants from other specialties
                if (specialtyId) {
                    $('#consultant_id option').each(function() {
                        var consultantSpecialty = $(this).data('specialty');
                        if (consultantSpecialty && consultantSpecialty != specialtyId) {
                            $(this).prop('disabled', true);
                        }
                    });
                }
                
                // Reset consultant selection
                $('#consultant_id').val('');
            });

            // Trigger change events to initialize form state
            $('#referrer_type').trigger('change');
            $('#specialty_id').trigger('change');
        });
    </script>
@stop 