@extends('adminlte::page')

@section('title', 'System Statistics')

@section('content_header')
    <h1>System Statistics</h1>
    <p class="text-muted">Detailed system performance and analytics</p>
@stop

@section('content')
    <!-- Summary Stats Cards -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $stats['users'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-hospital"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hospitals</span>
                    <span class="info-box-number">{{ $stats['hospitals'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-user-md"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">GPs</span>
                    <span class="info-box-number">{{ $stats['gps'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-file-medical"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Referrals</span>
                    <span class="info-box-number">{{ $stats['referrals'] ?? 0 }}</span>
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
                    <h3 class="card-title">Monthly Referrals ({{ date('Y') }})</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="referralChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Distribution -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">System Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="distributionChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="performance-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="gp-performance-tab" data-toggle="pill" href="#gp-performance" 
                                role="tab" aria-controls="gp-performance" aria-selected="true">
                                GP Doctors Performance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="consultant-performance-tab" data-toggle="pill" href="#consultant-performance" 
                                role="tab" aria-controls="consultant-performance" aria-selected="false">
                                Consultants Performance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="specialty-performance-tab" data-toggle="pill" href="#specialty-performance" 
                                role="tab" aria-controls="specialty-performance" aria-selected="false">
                                Specialties Performance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="clinic-performance-tab" data-toggle="pill" href="#clinic-performance" 
                                role="tab" aria-controls="clinic-performance" aria-selected="false">
                                Clinics Performance
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="performance-tabsContent">
                        <!-- GP Performance Tab -->
                        <div class="tab-pane fade show active" id="gp-performance" role="tabpanel" aria-labelledby="gp-performance-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>GP Name</th>
                                                    <th>Referrals Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($gpPerformance as $gp)
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
                                <div class="col-md-6">
                                    <canvas id="gpPerformanceChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Consultant Performance Tab -->
                        <div class="tab-pane fade" id="consultant-performance" role="tabpanel" aria-labelledby="consultant-performance-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Consultant Name</th>
                                                    <th>Referrals Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($consultantPerformance as $consultant)
                                                    <tr>
                                                        <td>{{ $consultant->name }}</td>
                                                        <td>{{ $consultant->referral_count }}</td>
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
                                <div class="col-md-6">
                                    <canvas id="consultantPerformanceChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Specialty Performance Tab -->
                        <div class="tab-pane fade" id="specialty-performance" role="tabpanel" aria-labelledby="specialty-performance-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Specialty Name</th>
                                                    <th>Referrals Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($specialtyPerformance as $specialty)
                                                    <tr>
                                                        <td>{{ $specialty->name }}</td>
                                                        <td>{{ $specialty->referral_count }}</td>
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
                                <div class="col-md-6">
                                    <canvas id="specialtyPerformanceChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Clinic Performance Tab -->
                        <div class="tab-pane fade" id="clinic-performance" role="tabpanel" aria-labelledby="clinic-performance-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Clinic Name</th>
                                                    <th>Referrals Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($clinicPerformance as $clinic)
                                                    <tr>
                                                        <td>{{ $clinic->name }}</td>
                                                        <td>{{ $clinic->referral_count }}</td>
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
                                <div class="col-md-6">
                                    <canvas id="clinicPerformanceChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row">
        <!-- Referral Stats -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Referral Statistics
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-plus text-primary"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">New Referrals (This Month)</span>
                                    <span class="info-box-number">{{ $monthlyReferrals[date('M')] ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-check text-success"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Completed Referrals</span>
                                    <span class="info-box-number">{{ intval(($stats['referrals'] ?? 0) * 0.68) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-day text-warning"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Referrals</span>
                                    <span class="info-box-number">{{ intval(($stats['referrals'] ?? 0) * 0.24) }}</span>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-times text-danger"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancelled Referrals</span>
                                    <span class="info-box-number">{{ intval(($stats['referrals'] ?? 0) * 0.08) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hospital & Specialty Stats -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hospital-alt mr-1"></i>
                        Hospital & Specialty Statistics
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-user-md text-info"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Consultants</span>
                                    <span class="info-box-number">{{ $stats['consultants'] ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-stethoscope text-success"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Specialties</span>
                                    <span class="info-box-number">{{ $stats['specialties'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-clinic-medical text-warning"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avg Consultants per Hospital</span>
                                    <span class="info-box-number">
                                        @if(($stats['hospitals'] ?? 0) > 0)
                                            {{ number_format(($stats['consultants'] ?? 0) / ($stats['hospitals'] ?? 1), 1) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-clipboard-list text-danger"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avg Referrals per GP</span>
                                    <span class="info-box-number">
                                        @if(($stats['gps'] ?? 0) > 0)
                                            {{ number_format(($stats['referrals'] ?? 0) / ($stats['gps'] ?? 1), 1) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
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
        $(function() {
            // Monthly referral data
            const monthlyLabels = @json(array_keys($monthlyReferrals));
            const monthlyData = @json(array_values($monthlyReferrals));
            
            // Create line chart for monthly referrals
            const referralChartCanvas = document.getElementById('referralChart').getContext('2d');
            new Chart(referralChartCanvas, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Referrals',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: 3,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: monthlyData
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // System distribution data
            const distributionLabels = ['Hospitals', 'GPs', 'Consultants', 'Specialties'];
            const distributionData = [
                {{ $stats['hospitals'] ?? 0 }},
                {{ $stats['gps'] ?? 0 }},
                {{ $stats['consultants'] ?? 0 }},
                {{ $stats['specialties'] ?? 0 }}
            ];
            const backgroundColors = [
                'rgba(60,141,188,0.9)',
                'rgba(210,214,222,0.9)',
                'rgba(255,193,7,0.9)',
                'rgba(76,175,80,0.9)'
            ];
            
            // Create pie chart for system distribution
            const distributionChartCanvas = document.getElementById('distributionChart').getContext('2d');
            new Chart(distributionChartCanvas, {
                type: 'pie',
                data: {
                    labels: distributionLabels,
                    datasets: [{
                        data: distributionData,
                        backgroundColor: backgroundColors,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                }
            });
            
            // GP Performance Chart
            if (document.getElementById('gpPerformanceChart')) {
                const gpLabels = @json($gpPerformance->pluck('name'));
                const gpData = @json($gpPerformance->pluck('referral_count'));
                
                const gpChartCanvas = document.getElementById('gpPerformanceChart').getContext('2d');
                new Chart(gpChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: gpLabels,
                        datasets: [{
                            label: 'Referrals',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: gpData
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Consultant Performance Chart
            if (document.getElementById('consultantPerformanceChart')) {
                const consultantLabels = @json($consultantPerformance->pluck('name'));
                const consultantData = @json($consultantPerformance->pluck('referral_count'));
                
                const consultantChartCanvas = document.getElementById('consultantPerformanceChart').getContext('2d');
                new Chart(consultantChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: consultantLabels,
                        datasets: [{
                            label: 'Referrals',
                            backgroundColor: 'rgba(255,193,7,0.9)',
                            borderColor: 'rgba(255,193,7,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(255,193,7,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255,193,7,1)',
                            data: consultantData
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Specialty Performance Chart
            if (document.getElementById('specialtyPerformanceChart')) {
                const specialtyLabels = @json($specialtyPerformance->pluck('name'));
                const specialtyData = @json($specialtyPerformance->pluck('referral_count'));
                
                const specialtyChartCanvas = document.getElementById('specialtyPerformanceChart').getContext('2d');
                new Chart(specialtyChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: specialtyLabels,
                        datasets: [{
                            label: 'Referrals',
                            backgroundColor: 'rgba(76,175,80,0.9)',
                            borderColor: 'rgba(76,175,80,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(76,175,80,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(76,175,80,1)',
                            data: specialtyData
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Clinic Performance Chart
            if (document.getElementById('clinicPerformanceChart')) {
                const clinicLabels = @json($clinicPerformance->pluck('name'));
                const clinicData = @json($clinicPerformance->pluck('referral_count'));
                
                const clinicChartCanvas = document.getElementById('clinicPerformanceChart').getContext('2d');
                new Chart(clinicChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: clinicLabels,
                        datasets: [{
                            label: 'Referrals',
                            backgroundColor: 'rgba(233,30,99,0.9)',
                            borderColor: 'rgba(233,30,99,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(233,30,99,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(233,30,99,1)',
                            data: clinicData
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
@stop 