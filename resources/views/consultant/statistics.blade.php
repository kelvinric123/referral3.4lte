@extends('adminlte::page')

@section('title', 'My Statistics')

@section('content_header')
    <h1>My Statistics</h1>
    <p class="text-muted">Your performance and referral analytics</p>
@stop

@section('content')
    <!-- Summary Stats Cards -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-file-medical"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Referrals</span>
                    <span class="info-box-number">{{ $stats['my_referrals'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number">{{ $stats['completed_referrals'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">{{ $stats['pending_referrals'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">This Month</span>
                    <span class="info-box-number">{{ $stats['this_month_referrals'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $stats['in_progress_referrals'] ?? 0 }}</h3>
                    <p>In Progress</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $stats['cancelled_referrals'] ?? 0 }}</h3>
                    <p>Cancelled/Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $stats['referring_gps'] ?? 0 }}</h3>
                    <p>Referring GPs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ $stats['referring_hospitals'] ?? 0 }}</h3>
                    <p>Referring Hospitals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Monthly Referrals -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Monthly Referrals ({{ date('Y') }})</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="referralChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Status Distribution -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Referral Status Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Tables -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Referring GPs</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>GP Name</th>
                                    <th>Referrals Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topReferringGPs as $gp)
                                    <tr>
                                        <td>{{ $gp->name }}</td>
                                        <td>{{ $gp->referral_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Referring Hospitals</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Referrals Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topReferringHospitals as $hospital)
                                    <tr>
                                        <td>{{ $hospital->name }}</td>
                                        <td>{{ $hospital->referral_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Referral Status Breakdown</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalReferrals = $stats['my_referrals'] ?? 1;
                                @endphp
                                @forelse($referralsByStatus as $status)
                                    <tr>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $status->status == 'Completed' ? 'success' : 
                                                ($status->status == 'Pending' ? 'warning' : 
                                                ($status->status == 'In Progress' ? 'info' : 'danger')) 
                                            }}">
                                                {{ $status->status }}
                                            </span>
                                        </td>
                                        <td>{{ $status->count }}</td>
                                        <td>{{ $totalReferrals > 0 ? round(($status->count / $totalReferrals) * 100, 1) : 0 }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Referrals Chart
        const monthlyData = @json($monthlyReferrals ?? []);
        const monthlyLabels = Object.keys(monthlyData);
        const monthlyValues = Object.values(monthlyData);

        const referralCtx = document.getElementById('referralChart').getContext('2d');
        const referralChart = new Chart(referralCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'My Referrals',
                    data: monthlyValues,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Referral Status Chart
        const statusData = @json($referralsByStatus ?? []);
        const statusLabels = statusData.map(item => item.status);
        const statusValues = statusData.map(item => item.count);
        const statusColors = statusLabels.map(status => {
            switch(status) {
                case 'Completed': return '#28a745';
                case 'Pending': return '#ffc107';
                case 'In Progress': return '#17a2b8';
                default: return '#dc3545';
            }
        });

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        console.log('Consultant statistics loaded');
    </script>
@stop 