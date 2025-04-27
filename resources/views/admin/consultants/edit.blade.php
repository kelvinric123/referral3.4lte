@extends('adminlte::page')

@section('title', 'Edit Consultant')

@section('content_header')
    <h1>Edit Consultant: {{ $consultant->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.consultants.update', $consultant) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $consultant->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hospital_id">Hospital</label>
                            <select name="hospital_id" id="hospital_id" class="form-control @error('hospital_id') is-invalid @enderror" required>
                                <option value="">Select Hospital</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hospital_id', $consultant->hospital_id) == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialty_id">Specialty</label>
                            <select name="specialty_id" id="specialty_id" class="form-control @error('specialty_id') is-invalid @enderror" required>
                                <option value="">Select Specialty</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ old('specialty_id', $consultant->specialty_id) == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }} ({{ $specialty->hospital->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('specialty_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $consultant->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $consultant->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $consultant->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Languages</label>
                            <div class="select-group">
                                @foreach($languages as $language)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="languages[]" id="language_{{ $loop->index }}" 
                                               value="{{ $language }}" {{ (is_array(old('languages', $consultant->languages)) && in_array($language, old('languages', $consultant->languages))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="language_{{ $loop->index }}">
                                            {{ $language }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('languages')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="qualifications">Qualifications</label>
                    <textarea name="qualifications" id="qualifications" class="form-control @error('qualifications') is-invalid @enderror" 
                              rows="3">{{ old('qualifications', $consultant->qualifications) }}</textarea>
                    @error('qualifications')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" id="experience" class="form-control @error('experience') is-invalid @enderror" 
                           value="{{ old('experience', $consultant->experience) }}" required>
                    @error('experience')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" 
                              rows="4">{{ old('bio', $consultant->bio) }}</textarea>
                    @error('bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $consultant->email) }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $consultant->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    <small class="form-text text-muted">
                        Leave blank to keep current password. Default password is "qmed.asia".
                    </small>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $consultant->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Consultant</button>
                    <a href="{{ route('admin.consultants.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .select-group {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }
        @media (max-width: 768px) {
            .select-group {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@stop 