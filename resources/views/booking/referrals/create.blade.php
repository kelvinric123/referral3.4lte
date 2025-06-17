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
                <a href="{{ route('booking.referrals.index') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-arrow-left"></i> Back to Referrals
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('booking.referrals.store') }}" method="POST">
                @csrf

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
                                    <label>ID Type</label>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="id_type" id="id_type_ic" value="ic" {{ old('id_type', 'ic') == 'ic' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="id_type_ic">
                                            Malaysian IC
                                        </label>
                                    </div>
                                    <div class="form-check-inline ml-3">
                                        <input class="form-check-input" type="radio" name="id_type" id="id_type_passport" value="passport" {{ old('id_type') == 'passport' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="id_type_passport">
                                            Passport
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="patient_id" id="patient_id_label">IC Number</label>
                                    <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" value="{{ old('patient_id') }}" required>
                                    <small class="form-text text-muted" id="patient_id_help">Malaysian IC format: YYMMDD-PB-###G</small>
                                    @error('patient_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_dob">Date of Birth</label>
                                    <input type="date" class="form-control @error('patient_dob') is-invalid @enderror" id="patient_dob" name="patient_dob" value="{{ old('patient_dob') }}" required>
                                    @error('patient_dob')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_age">Age</label>
                                    <input type="number" class="form-control @error('patient_age') is-invalid @enderror" id="patient_age" name="patient_age" value="{{ old('patient_age') }}" min="0" max="150" required>
                                    @error('patient_age')
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

                                <div class="form-group">
                                    <label for="patient_email">Email (Optional)</label>
                                    <input type="email" class="form-control @error('patient_email') is-invalid @enderror" id="patient_email" name="patient_email" value="{{ old('patient_email') }}">
                                    @error('patient_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="patient_address">Address (Optional)</label>
                                    <textarea class="form-control @error('patient_address') is-invalid @enderror" id="patient_address" name="patient_address" rows="3">{{ old('patient_address') }}</textarea>
                                    @error('patient_address')
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
                                            <option value="{{ $hospital->id }}" {{ old('hospital_id', request('hospital_id')) == $hospital->id ? 'selected' : '' }}>
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
                                            <option value="{{ $specialty->id }}" {{ old('specialty_id', request('specialty_id')) == $specialty->id ? 'selected' : '' }}>
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
                                                    data-hospital="{{ $consultant->hospital_id }}"
                                                    {{ old('consultant_id', request('consultant_id')) == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }} ({{ $consultant->specialty->name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('consultant_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="preferred_date">Preferred Date</label>
                                    <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ date('Y-m-d') }}">
                                    @error('preferred_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="Normal" {{ old('priority', 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
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
                            <a href="{{ route('booking.referrals.index') }}" class="btn btn-default">Cancel</a>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for all select elements
            $('select').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            
            // Force patient name to uppercase
            $('#patient_name').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Handle ID type change
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

            // Trigger calculation when IC number changes
            $('#patient_id').on('input', function() {
                if ($('input[name="id_type"]:checked').val() === 'ic') {
                    calculateFromIC();
                }
            });

            // Filter consultants based on hospital and specialty selection
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
            
            filterConsultants();
        });
    </script>
@stop 