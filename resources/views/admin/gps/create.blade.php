@extends('adminlte::page')

@section('title', 'Add New GP')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Add New GP</h1>
        <a href="{{ route('admin.gps.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gps.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Basic Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="clinic_id">Clinic</label>
                                    <select class="form-control @error('clinic_id') is-invalid @enderror" 
                                        id="clinic_id" name="clinic_id" required>
                                        <option value="">-- Select Clinic --</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                                {{ $clinic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('clinic_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="qualifications">Qualifications</label>
                                    <input type="text" class="form-control @error('qualifications') is-invalid @enderror" 
                                        id="qualifications" name="qualifications" value="{{ old('qualifications') }}" required>
                                    @error('qualifications')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="years_experience">Years of Experience</label>
                                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" 
                                        id="years_experience" name="years_experience" value="{{ old('years_experience', 0) }}" min="0" required>
                                    @error('years_experience')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Languages</label>
                                    <div class="select2-purple">
                                        <select class="form-control @error('languages') is-invalid @enderror" 
                                            id="languages" name="languages[]" multiple required>
                                            @foreach($languages as $language)
                                                <option value="{{ $language }}" 
                                                    {{ is_array(old('languages')) && in_array($language, old('languages')) ? 'selected' : '' }}>
                                                    {{ $language }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('languages')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                            id="is_active" name="is_active" value="1" 
                                            {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Contact & Login Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" value="{{ old('password', '88888888') }}">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save GP
                    </button>
                    <a href="{{ route('admin.gps.index') }}" class="btn btn-default">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(function () {
        $('#languages').select2({
            theme: 'bootstrap4',
            placeholder: 'Select languages',
        });
    });
</script>
@stop 