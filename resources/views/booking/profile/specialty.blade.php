@extends('adminlte::page')

@section('title', 'Specialty Profiles')

@section('content_header')
    <h1>Specialty Profiles</h1>
@stop

@section('content')
    <!-- Search Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('booking.profile.specialty') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search specialties by name or description..." value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Specialties Grid -->
    <div class="row">
        @forelse($specialties as $specialty)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">{{ $specialty->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if($specialty->description)
                            <p class="card-text">{{ Str::limit($specialty->description, 120) }}</p>
                        @endif
                        
                        <!-- Consultants Count -->
                        <div class="mb-2">
                            <strong>Available Consultants:</strong> {{ $specialty->consultants->count() }}
                        </div>

                        <!-- Hospital -->
                        <div class="mb-2">
                            <strong>Hospital:</strong> {{ $specialty->hospital->name ?? 'N/A' }}
                        </div>

                        <!-- Sample Consultants -->
                        @if($specialty->consultants->count() > 0)
                            <div class="mb-2">
                                <strong>Top Consultants:</strong><br>
                                @foreach($specialty->consultants->take(3) as $consultant)
                                    <small class="text-muted d-block">{{ $consultant->name }} - {{ $consultant->hospital->name ?? 'N/A' }}</small>
                                @endforeach
                                @if($specialty->consultants->count() > 3)
                                    <small class="text-muted">+{{ $specialty->consultants->count() - 3 }} more</small>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="{{ route('booking.referrals.create', ['specialty_id' => $specialty->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Referral
                            </a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#specialtyModal{{ $specialty->id }}">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specialty Modal -->
            <div class="modal fade" id="specialtyModal{{ $specialty->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $specialty->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($specialty->description)
                                        <h6>Description</h6>
                                        <p>{{ $specialty->description }}</p>
                                    @endif
                                    
                                    <h6>Available Consultants ({{ $specialty->consultants->count() }})</h6>
                                    @forelse($specialty->consultants->take(10) as $consultant)
                                        <div class="mb-2">
                                            <strong>{{ $consultant->name }}</strong><br>
                                            <small class="text-muted">{{ $consultant->hospital->name ?? 'N/A' }}</small><br>
                                            <small class="text-info">{{ $consultant->qualifications }}</small>
                                        </div>
                                    @empty
                                        <p class="text-muted">No consultants available for this specialty.</p>
                                    @endforelse
                                    @if($specialty->consultants->count() > 10)
                                        <div class="text-muted">+{{ $specialty->consultants->count() - 10 }} more consultants</div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Hospital Information</h6>
                                    @if($specialty->hospital)
                                        <div class="mb-2">
                                            <strong>{{ $specialty->hospital->name }}</strong><br>
                                            <small class="text-muted">{{ $specialty->hospital->address ?? 'Address not available' }}</small><br>
                                            <small class="text-info">{{ $specialty->hospital->phone ?? 'Phone not available' }}</small>
                                        </div>
                                    @else
                                        <p class="text-muted">No hospital information available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('booking.referrals.create', ['specialty_id' => $specialty->id]) }}" class="btn btn-primary">
                                Create Referral for This Specialty
                            </a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p>No specialties found.</p>
                        @if($search)
                            <a href="{{ route('booking.profile.specialty') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View All Specialties
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($specialties->hasPages())
        <div class="d-flex justify-content-center">
            {{ $specialties->appends(request()->query())->links() }}
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Specialty Profiles loaded'); </script>
@stop 