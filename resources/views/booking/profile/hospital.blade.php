@extends('adminlte::page')

@section('title', 'Hospital Profiles')

@section('content_header')
    <h1>Hospital Profiles</h1>
@stop

@section('content')
    <!-- Search Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('booking.profile.hospital') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search hospitals by name, address, or city..." value="{{ $search }}">
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

    <!-- Hospitals Grid -->
    <div class="row">
        @forelse($hospitals as $hospital)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $hospital->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Location:</strong> {{ $hospital->address }}, {{ $hospital->city }}<br>
                            <strong>Phone:</strong> {{ $hospital->phone }}<br>
                            <strong>Email:</strong> {{ $hospital->email }}
                        </p>
                        @if($hospital->description)
                            <p class="card-text text-muted">{{ Str::limit($hospital->description, 100) }}</p>
                        @endif
                        
                        <!-- Specialties -->
                        @if($hospital->specialties->count() > 0)
                            <div class="mb-2">
                                <strong>Specialties:</strong><br>
                                @foreach($hospital->specialties->take(3) as $specialty)
                                    <span class="badge badge-info mr-1">{{ $specialty->name }}</span>
                                @endforeach
                                @if($hospital->specialties->count() > 3)
                                    <span class="text-muted">+{{ $hospital->specialties->count() - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <!-- Consultants Count -->
                        <div class="mb-2">
                            <strong>Consultants:</strong> {{ $hospital->consultants->count() }} available
                        </div>

                        <!-- Services Count -->
                        <div class="mb-2">
                            <strong>Services:</strong> {{ $hospital->services->count() }} offered
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="{{ route('booking.referrals.create', ['hospital_id' => $hospital->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Referral
                            </a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#hospitalModal{{ $hospital->id }}">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hospital Modal -->
            <div class="modal fade" id="hospitalModal{{ $hospital->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $hospital->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Contact Information</h6>
                                    <p>
                                        <strong>Location:</strong> {{ $hospital->address }}, {{ $hospital->city }}<br>
                                        <strong>Phone:</strong> {{ $hospital->phone }}<br>
                                        <strong>Email:</strong> {{ $hospital->email }}
                                    </p>
                                    @if($hospital->description)
                                        <h6>Description</h6>
                                        <p>{{ $hospital->description }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Specialties ({{ $hospital->specialties->count() }})</h6>
                                    @foreach($hospital->specialties as $specialty)
                                        <span class="badge badge-info mr-1 mb-1">{{ $specialty->name }}</span>
                                    @endforeach
                                    
                                    <h6 class="mt-3">Available Consultants ({{ $hospital->consultants->count() }})</h6>
                                    @foreach($hospital->consultants->take(5) as $consultant)
                                        <div class="mb-1">{{ $consultant->name }} - {{ $consultant->specialty->name ?? 'N/A' }}</div>
                                    @endforeach
                                    @if($hospital->consultants->count() > 5)
                                        <div class="text-muted">+{{ $hospital->consultants->count() - 5 }} more consultants</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('booking.referrals.create', ['hospital_id' => $hospital->id]) }}" class="btn btn-primary">
                                Create Referral to This Hospital
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
                        <p>No hospitals found.</p>
                        @if($search)
                            <a href="{{ route('booking.profile.hospital') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View All Hospitals
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($hospitals->hasPages())
        <div class="d-flex justify-content-center">
            {{ $hospitals->appends(request()->query())->links() }}
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hospital Profiles loaded'); </script>
@stop 