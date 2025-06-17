@extends('adminlte::page')

@section('title', 'My Loyalty Points')

@section('content_header')
    <h1>My Loyalty Points</h1>
@stop

@section('content')
    <!-- Booking Agent Details Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Profile & Points Summary</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Name:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->name }}</dd>
                        
                        <dt class="col-sm-4">Company:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->company->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->email }}</dd>
                        
                        <dt class="col-sm-4">Position:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->position ?? 'N/A' }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-gradient-success mb-3">
                        <span class="info-box-icon"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Loyalty Points</span>
                            <span class="info-box-number h2">{{ $currentBalance }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pointsThisMonth }}</h3>
                    <p>Points This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingPoints }}</h3>
                    <p>Points from Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $approvedPoints }}</h3>
                    <p>Points from Approved</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $completedPoints }}</h3>
                    <p>Points from Completed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalReferrals }}</h3>
                    <p>Total Referrals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-medical"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $currentBalance }}</h3>
                    <p>Current Balance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Loyalty Points Transaction History -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Loyalty Points Transaction History</h3>
        </div>
        <div class="card-body">
            @if($loyaltyPoints->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Referral ID</th>
                                <th>Patient</th>
                                <th>Hospital</th>
                                <th>Status</th>
                                <th>Points</th>
                                <th>Balance</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loyaltyPoints as $point)
                                <tr>
                                    <td>{{ $point->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($point->referral)
                                            <a href="{{ route('booking.referrals.show', $point->referral) }}">
                                                #{{ $point->referral->id }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($point->referral)
                                            {{ $point->referral->patient_name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($point->referral && $point->referral->hospital)
                                            {{ $point->referral->hospital->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @switch($point->status)
                                            @case('Pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('Approved')
                                                <span class="badge badge-success">Approved</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge badge-primary">Completed</span>
                                                @break
                                            @case('Rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                                @break
                                            @case('No Show')
                                                <span class="badge badge-secondary">No Show</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">{{ $point->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($point->points > 0)
                                            <strong class="text-success">+{{ $point->points }}</strong>
                                        @elseif($point->points < 0)
                                            <strong class="text-danger">{{ $point->points }}</strong>
                                        @else
                                            <span class="text-muted">{{ $point->points }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $point->balance }}</strong></td>
                                    <td>{{ $point->description ?? 'Referral points' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $loyaltyPoints->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h5>No loyalty points earned yet</h5>
                    <p class="text-muted">Start creating referrals to earn loyalty points!</p>
                    <a href="{{ route('booking.referrals.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Your First Referral
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Booking Agent Loyalty Points loaded'); </script>
@stop 