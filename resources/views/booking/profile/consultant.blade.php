@extends('adminlte::page')

@section('title', 'Consultant Profiles')

@section('content_header')
    <h1>Consultant Profiles</h1>
@stop

@section('content')
    <!-- Search and Filter Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('booking.profile.consultant') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search consultants..." value="{{ $search }}">
                            </div>
                            <div class="col-md-3">
                                <select name="specialty_id" class="form-control">
                                    <option value="">All Specialties</option>
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty->id }}" {{ $specialtyId == $specialty->id ? 'selected' : '' }}>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="hospital_id" class="form-control">
                                    <option value="">All Hospitals</option>
                                    @foreach($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}" {{ $hospitalId == $hospital->id ? 'selected' : '' }}>
                                            {{ $hospital->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultants Grid -->
    <div class="row">
        @forelse($consultants as $consultant)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">{{ $consultant->name }}</h5>
                        <small>{{ $consultant->specialty->name ?? 'General' }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Hospital:</strong> {{ $consultant->hospital->name ?? 'N/A' }}<br>
                            <strong>Experience:</strong> {{ $consultant->years_experience ?? 'N/A' }} years<br>
                            <strong>Gender:</strong> {{ ucfirst($consultant->gender) ?? 'N/A' }}
                        </p>
                        
                        @if($consultant->qualifications)
                            <p class="card-text">
                                <strong>Qualifications:</strong><br>
                                <small class="text-muted">{{ Str::limit($consultant->qualifications, 80) }}</small>
                            </p>
                        @endif

                        @if($consultant->bio)
                            <p class="card-text">
                                <strong>Bio:</strong><br>
                                <small class="text-muted">{{ Str::limit($consultant->bio, 100) }}</small>
                            </p>
                        @endif

                        <!-- Services -->
                        @if($consultant->services && $consultant->services->count() > 0)
                            <div class="mb-2">
                                <strong>Services:</strong><br>
                                @foreach($consultant->services->take(3) as $service)
                                    <span class="badge badge-success mr-1">{{ $service->name }}</span>
                                @endforeach
                                @if($consultant->services->count() > 3)
                                    <span class="text-muted">+{{ $consultant->services->count() - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <!-- Languages -->
                        @if($consultant->languages)
                            <div class="mb-2">
                                <strong>Languages:</strong>
                                @if(is_array($consultant->languages))
                                    {{ implode(', ', $consultant->languages) }}
                                @else
                                    {{ $consultant->languages }}
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="{{ route('booking.referrals.create', ['consultant_id' => $consultant->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Referral
                            </a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#consultantModal{{ $consultant->id }}">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultant Modal -->
            <div class="modal fade" id="consultantModal{{ $consultant->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $consultant->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Professional Information</h6>
                                    <p>
                                        <strong>Specialty:</strong> {{ $consultant->specialty->name ?? 'General' }}<br>
                                        <strong>Hospital:</strong> {{ $consultant->hospital->name ?? 'N/A' }}<br>
                                        <strong>Experience:</strong> {{ $consultant->years_experience ?? 'N/A' }} years<br>
                                        <strong>Gender:</strong> {{ ucfirst($consultant->gender) ?? 'N/A' }}
                                    </p>

                                    @if($consultant->qualifications)
                                        <h6>Qualifications</h6>
                                        <p>{{ $consultant->qualifications }}</p>
                                    @endif

                                    @if($consultant->languages)
                                        <h6>Languages</h6>
                                        <p>
                                            @if(is_array($consultant->languages))
                                                {{ implode(', ', $consultant->languages) }}
                                            @else
                                                {{ $consultant->languages }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($consultant->bio)
                                        <h6>Biography</h6>
                                        <p>{{ $consultant->bio }}</p>
                                    @endif

                                    @if($consultant->services && $consultant->services->count() > 0)
                                        <h6>Services Offered ({{ $consultant->services->count() }})</h6>
                                        @foreach($consultant->services as $service)
                                            <span class="badge badge-success mr-1 mb-1">{{ $service->name }}</span>
                                        @endforeach
                                    @endif

                                    <h6 class="mt-3">Contact Information</h6>
                                    <p>
                                        <strong>Hospital:</strong> {{ $consultant->hospital->name ?? 'N/A' }}<br>
                                        @if($consultant->hospital)
                                            <strong>Location:</strong> {{ $consultant->hospital->address }}, {{ $consultant->hospital->city }}<br>
                                            <strong>Phone:</strong> {{ $consultant->hospital->phone }}<br>
                                            <strong>Email:</strong> {{ $consultant->hospital->email }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('booking.referrals.create', ['consultant_id' => $consultant->id]) }}" class="btn btn-primary">
                                Create Referral to This Consultant
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
                        <p>No consultants found.</p>
                        @if($search || $specialtyId || $hospitalId)
                            <a href="{{ route('booking.profile.consultant') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View All Consultants
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($consultants->hasPages())
        <div class="d-flex justify-content-center">
            {{ $consultants->appends(request()->query())->links() }}
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Consultant Profiles loaded'); </script>
@stop 