@extends('adminlte::page')

@section('title', 'GP Doctor Dashboard')

@section('content_header')
    <h1>GP Doctor Dashboard</h1>
@stop

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-md mr-2"></i> GP Account Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong><i class="fas fa-envelope mr-1"></i> Login Email:</strong>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-key mr-1"></i> Password:</strong>
                            <p class="text-muted">88888888 (default password)</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-clock mr-1"></i> Last Login:</strong>
                            <p class="text-muted">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d M Y, h:i A') : 'First login' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Patients</h3>
                    <p>Patient Management</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Appointments</h3>
                    <p>Today's Appointments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Referrals</h3>
                    <p>Manage Referrals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <a href="{{ route('doctor.referrals.index') }}" class="small-box-footer">View Referrals <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Loyalty</h3>
                    <p>Loyalty Points</p>
                </div>
                <div class="icon">
                    <i class="fas fa-award"></i>
                </div>
                <a href="{{ route('doctor.loyalty-points.index') }}" class="small-box-footer">View Points <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Recent Referrals & Loyalty Points Summary -->
    <div class="row">
        <!-- Recent Referrals -->
        <div class="col-md-6">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Recent Referrals</h3>
                    <div class="card-tools">
                        <a href="{{ route('doctor.referrals.index') }}" class="btn btn-sm btn-warning">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Hospital</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentReferrals) && $recentReferrals->count() > 0)
                                    @foreach($recentReferrals as $referral)
                                        <tr>
                                            <td>{{ $referral->patient_name }}</td>
                                            <td>{{ $referral->hospital->name ?? 'N/A' }}</td>
                                            <td>
                                                @switch($referral->status)
                                                    @case('Pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                        @break
                                                    @case('Approved')
                                                        <span class="badge badge-success">Approved</span>
                                                        @break
                                                    @case('Rejected')
                                                        <span class="badge badge-danger">Rejected</span>
                                                        @break
                                                    @case('Completed')
                                                        <span class="badge badge-primary">Completed</span>
                                                        @break
                                                    @case('No Show')
                                                        <span class="badge badge-secondary">No Show</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-info">{{ $referral->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $referral->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No recent referrals found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loyalty Points Summary -->
        <div class="col-md-6">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Points Summary</h3>
                    <div class="card-tools">
                        <a href="{{ route('doctor.loyalty-points.index') }}" class="btn btn-sm btn-danger">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($loyaltyPointsSum))
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-gradient-success">
                                    <span class="info-box-icon"><i class="fas fa-star"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Points</span>
                                        <span class="info-box-number">{{ $loyaltyPointsSum }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-gradient-info">
                                    <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">This Month</span>
                                        <span class="info-box-number">{{ $loyaltyPointsThisMonth ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h5>Points by Status</h5>
                            <div class="progress-group">
                                <span class="progress-text">Completed Referrals</span>
                                <span class="float-right"><b>{{ $completedPoints ?? 0 }}</b> points</span>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: {{ $loyaltyPointsSum ? ($completedPoints / $loyaltyPointsSum) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Approved Referrals</span>
                                <span class="float-right"><b>{{ $approvedPoints ?? 0 }}</b> points</span>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: {{ $loyaltyPointsSum ? ($approvedPoints / $loyaltyPointsSum) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Pending Referrals</span>
                                <span class="float-right"><b>{{ $pendingPoints ?? 0 }}</b> points</span>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: {{ $loyaltyPointsSum ? ($pendingPoints / $loyaltyPointsSum) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <p>No loyalty points data available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('GP Doctor dashboard loaded'); </script>
@stop 