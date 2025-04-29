@extends('adminlte::page')

@section('title', 'Add New GP Doctor')

@section('content_header')
    <h1>Add New GP Doctor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">GP Doctor Details</h3>
        </div>
        <form action="{{ route('hospital.gps.store') }}" method="POST">
            @csrf
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
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
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

                <div class="form-group">
                    <label for="clinic_id">Clinic</label>
                    <select class="form-control @error('clinic_id') is-invalid @enderror" 
                            id="clinic_id" name="clinic_id">
                        <option value="">Select Clinic</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name }} ({{ $clinic->city }}, {{ $clinic->state }})
                            </option>
                        @endforeach
                    </select>
                    @error('clinic_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="years_experience">Years of Experience</label>
                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" 
                           id="years_experience" name="years_experience" value="{{ old('years_experience') }}">
                    @error('years_experience')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qualifications">Qualifications</label>
                    <textarea class="form-control @error('qualifications') is-invalid @enderror" 
                              id="qualifications" name="qualifications">{{ old('qualifications') }}</textarea>
                    @error('qualifications')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create GP Doctor</button>
                <a href="{{ route('hospital.gps.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop 