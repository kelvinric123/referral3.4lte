@extends('adminlte::page')

@section('title', 'Edit Referral')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Referral #{{ $referral->id }}</h1>
        <div>
            <a href="{{ route('booking.referrals.index') }}" class="btn btn-default mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('booking.referrals.show', $referral->id) }}" class="btn btn-info mr-2">
                <i class="fas fa-eye"></i> View Only
            </a>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('booking.referrals.update', $referral->id) }}" method="POST">
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
                                    <label><strong>Name</strong></label>
                                    <input type="text" class="form-control @error('patient_name') is-invalid @enderror text-uppercase" name="patient_name" value="{{ old('patient_name', $referral->patient_name) }}" required style="text-transform: uppercase;">
                                    @error('patient_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>ID Type</strong></label>
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
                                    <label id="patient_id_label"><strong>IC Number</strong></label>
                                    <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id', $referral->patient_id) }}" required>
                                    <small class="form-text text-muted" id="patient_id_help">Malaysian IC format: YYMMDD-PB-###G</small>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>Date of Birth</strong></label>
                                    <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob', $referral->patient_dob ? date('Y-m-d', strtotime($referral->patient_dob)) : '') }}" required>
                                    @error('patient_dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>Age</strong></label>
                                    <input type="number" class="form-control @error('patient_age') is-invalid @enderror" id="patient_age" name="patient_age" value="{{ old('patient_age', $referral->patient_age ?? '') }}" min="0" max="150" required>
                                    @error('patient_age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Contact Number</strong></label>
                                    <input type="text" class="form-control @error('patient_contact') is-invalid @enderror" name="patient_contact" value="{{ old('patient_contact', $referral->patient_contact) }}" required>
                                    @error('patient_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>Email</strong></label>
                                    <input type="email" class="form-control @error('patient_email') is-invalid @enderror" name="patient_email" value="{{ old('patient_email', $referral->patient_email) }}">
                                    @error('patient_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>Address</strong></label>
                                    <textarea class="form-control @error('patient_address') is-invalid @enderror" name="patient_address" rows="3">{{ old('patient_address', $referral->patient_address) }}</textarea>
                                    @error('patient_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Preferred Date</strong></label>
                                    <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" name="preferred_date" value="{{ old('preferred_date', $referral->preferred_date ? date('Y-m-d', strtotime($referral->preferred_date)) : '') }}" min="{{ date('Y-m-d') }}">
                                    @error('preferred_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Priority</strong></label>
                                    <select class="form-control @error('priority') is-invalid @enderror" name="priority" required>
                                        <option value="Normal" {{ old('priority', $referral->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Urgent" {{ old('priority', $referral->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="Emergency" {{ old('priority', $referral->priority) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hospital & Consultant Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-hospital mr-2"></i>
                            Hospital & Consultant Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Hospital</strong></label>
                                    <select class="form-control @error('hospital_id') is-invalid @enderror" id="hospital_id" name="hospital_id" required>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Specialty</strong></label>
                                    <select class="form-control @error('specialty_id') is-invalid @enderror" id="specialty_id" name="specialty_id" required>
                                        <option value="">Select Specialty</option>
                                        @foreach($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" {{ old('specialty_id', $referral->specialty_id) == $specialty->id ? 'selected' : '' }}>
                                                {{ $specialty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialty_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Consultant</strong></label>
                                    <select class="form-control @error('consultant_id') is-invalid @enderror" id="consultant_id" name="consultant_id" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" 
                                                    data-specialty="{{ $consultant->specialty_id }}"
                                                    data-hospital="{{ $consultant->hospital_id }}"
                                                    {{ old('consultant_id', $referral->consultant_id) == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('consultant_id')
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
                            <label><strong>Diagnosis/Condition</strong></label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" rows="3" required>{{ old('diagnosis', $referral->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Clinical History</strong></label>
                            <textarea class="form-control @error('clinical_history') is-invalid @enderror" name="clinical_history" rows="3">{{ old('clinical_history', $referral->clinical_history) }}</textarea>
                            @error('clinical_history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Additional Remarks</strong></label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" rows="3">{{ old('remarks', $referral->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Current Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            Current Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @php
                                $statusClass = [
                                    'Pending' => 'secondary',
                                    'Approved' => 'success',
                                    'Rejected' => 'danger',
                                    'No Show' => 'warning',
                                    'Completed' => 'primary',
                                    'Cancelled' => 'dark'
                                ][$referral->status] ?? 'secondary';
                            @endphp
                            <h4>
                                <span class="badge badge-{{ $statusClass }} badge-lg">
                                    {{ $referral->status }}
                                </span>
                            </h4>
                        </div>
                        
                        @if($referral->status === 'Pending')
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                Only pending referrals can be edited.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Important Notice
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <li>Only pending referrals can be modified</li>
                                <li>Changes will reset any approval process</li>
                                <li>Ensure all patient information is accurate</li>
                                <li>Double-check hospital and consultant selection</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('booking.referrals.show', $referral->id) }}" class="btn btn-default">
                            <i class="fas fa-arrow-left mr-2"></i> Cancel Changes
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Update Referral
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <style>
        .badge-lg {
            font-size: 1.1em;
            padding: 0.5em 1em;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            
            $('input[name="patient_name"]').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            $('input[name="id_type"]').on('change', function() {
                const idType = $(this).val();
                
                if (idType === 'ic') {
                    $('#patient_id_label').text('IC Number');
                    $('#patient_id_help').text('Malaysian IC format: YYMMDD-PB-###G').show();
                    $('#patient_dob').prop('readonly', true);
                    $('#patient_age').prop('readonly', true);
                    
                    if ($('#patient_id').val()) {
                        calculateFromIC();
                    }
                } else {
                    $('#patient_id_label').text('Passport Number');
                    $('#patient_id_help').hide();
                    $('#patient_dob').prop('readonly', false);
                    $('#patient_age').prop('readonly', false);
                }
            });

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
                    
                    const dobString = dob.getFullYear() + '-' + 
                                    String(dob.getMonth() + 1).padStart(2, '0') + '-' + 
                                    String(dob.getDate()).padStart(2, '0');
                    
                    $('#patient_dob').val(dobString);
                    
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();
                    
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    
                    $('#patient_age').val(age);
                }
            }

            $('#patient_id').on('input', function() {
                if ($('input[name="id_type"]:checked').val() === 'ic') {
                    calculateFromIC();
                }
            });

            function filterConsultants() {
                const hospitalId = $('#hospital_id').val();
                const specialtyId = $('#specialty_id').val();
                
                $('#consultant_id option').each(function() {
                    const $option = $(this);
                    if ($option.val() === '') return true;
                    
                    const consultantHospital = $option.data('hospital');
                    const consultantSpecialty = $option.data('specialty');
                    
                    let show = true;
                    if (hospitalId && consultantHospital != hospitalId) show = false;
                    if (specialtyId && consultantSpecialty != specialtyId) show = false;
                    
                    $option.toggle(show);
                });
                
                if (!$('#consultant_id option:selected').is(':visible')) {
                    $('#consultant_id').val('').trigger('change');
                }
            }

            $('#hospital_id').on('change', filterConsultants);
            $('#specialty_id').on('change', filterConsultants);
            
            $('input[name="id_type"]:checked').trigger('change');
            filterConsultants();
        });
    </script>
@stop 