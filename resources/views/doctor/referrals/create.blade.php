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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Patient Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="patient_name">Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_name" id="patient_name" class="form-control @error('patient_name') is-invalid @enderror" value="{{ old('patient_name') }}" required>
                                    @error('patient_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_id">Patient ID/ID Number <span class="text-danger">*</span></label>
                                    <input type="text" name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" value="{{ old('patient_id') }}" required>
                                    @error('patient_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_dob">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="patient_dob" id="patient_dob" class="form-control @error('patient_dob') is-invalid @enderror" value="{{ old('patient_dob') }}" required>
                                    @error('patient_dob')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Referral Details</h3>
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
                                    <label for="consultant_id">Consultant <span class="text-danger">*</span></label>
                                    <select name="consultant_id" id="consultant_id" class="form-control @error('consultant_id') is-invalid @enderror" required>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }} ({{ $consultant->specialty->name ?? 'No Specialty' }})
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
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Medical Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                                    <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control @error('diagnosis') is-invalid @enderror" required>{{ old('diagnosis') }}</textarea>
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
                                    <label for="remarks">Remarks</label>
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
                            <a href="{{ route('doctor.referrals.index') }}" class="btn btn-secondary">
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

@section('js')
<script>
    $(document).ready(function() {
        // Dynamic loading of consultants based on specialty selection
        $('#specialty_id').change(function() {
            var specialtyId = $(this).val();
            if (specialtyId) {
                // Filter the consultant dropdown to show only consultants of the selected specialty
                $('#consultant_id option').each(function() {
                    if ($(this).val() === '') {
                        return; // Skip the placeholder option
                    }
                    
                    var consultantText = $(this).text();
                    var specialtyName = $('#specialty_id option:selected').text().trim();
                    
                    if (consultantText.includes(specialtyName)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                
                // Reset the consultant selection
                $('#consultant_id').val('');
            } else {
                // If no specialty is selected, show all consultants
                $('#consultant_id option').show();
            }
        });
    });
</script>
@stop 