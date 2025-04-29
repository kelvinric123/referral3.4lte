@extends('adminlte::page')

@section('title', 'Hospital Statistics')

@section('content_header')
    <h1>Hospital Statistics</h1>
    <p class="text-muted">Detailed hospital performance and analytics</p>
@stop

@section('content')
    <!-- Summary Stats Cards -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-user-md"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Consultants</span>
                    <span class="info-box-number">{{ $stats['consultants'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-stethoscope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Specialties</span>
                    <span class="info-box-number">{{ $stats['specialties'] ?? 0 }}</span>
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
        <div class="col-md-12">
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
                                    <span class="info-box-number">{{ $stats['completed_referrals'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-day text-warning"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Referrals</span>
                                    <span class="info-box-number">{{ $stats['pending_referrals'] ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <div class="info-box mb-3 bg-light">
                                <span class="info-box-icon"><i class="fas fa-calendar-times text-danger"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancelled Referrals</span>
                                    <span class="info-box-number">{{ $stats['cancelled_referrals'] ?? 0 }}</span>
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
                                    <span class="info-box-text">Avg Referrals per Consultant</span>
                                    <span class="info-box-number">
                                        @if(($stats['consultants'] ?? 0) > 0)
                                            {{ number_format(($stats['referrals'] ?? 0) / ($stats['consultants'] ?? 1), 1) }}
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
        });
    </script>
@stop 