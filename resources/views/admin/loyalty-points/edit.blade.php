@extends('adminlte::page')

@section('title', 'Edit Loyalty Point Setting')

@section('content_header')
    <h1>Edit Loyalty Point Setting</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit {{ $loyaltyPointSetting->entity_type }} Loyalty Points for {{ $loyaltyPointSetting->referral_status }} Status</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.loyalty-point-settings.update', $loyaltyPointSetting->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="entity_type">Entity Type</label>
                    <input type="text" class="form-control" id="entity_type" value="{{ $loyaltyPointSetting->entity_type }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="referral_status">Referral Status</label>
                    <input type="text" class="form-control" id="referral_status" value="{{ $loyaltyPointSetting->referral_status }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="points">Points</label>
                    <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" value="{{ old('points', $loyaltyPointSetting->points) }}" min="0">
                    @error('points')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $loyaltyPointSetting->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $loyaltyPointSetting->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Setting</button>
                    <a href="{{ route('admin.loyalty-point-settings.index') }}" class="btn btn-secondary">Cancel</a>
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
            // Any JS functionality can be added here
        });
    </script>
@stop 