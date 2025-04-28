@extends('adminlte::page')

@section('title', 'Super Admin Dashboard')

@section('content_header')
    <h1>Super Admin Dashboard</h1>
    <p class="text-muted">Overview of system performance and statistics</p>
@stop

@section('content')
    <!-- Summary Stats Boxes -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="/admin/users" class="small-box-footer">Manage Users <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Hospital::count() ?? 12 }}</h3>
                    <p>Registered Hospitals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <a href="/admin/hospitals" class="small-box-footer">Manage Hospitals <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\GP::count() ?? 48 }}</h3>
                    <p>Registered GPs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <a href="/admin/gps" class="small-box-footer">Manage GPs <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Referral::count() ?? 154 }}</h3>
                    <p>Total Referrals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <a href="/admin/referrals" class="small-box-footer">View Referrals <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Recent Activity and System Health -->
    <div class="row">
        <!-- Recent Referrals -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Referrals</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Referrer</th> 
                                    <th>Specialty</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentReferrals = \App\Models\Referral::with(['hospital', 'specialty'])
                                        ->latest()
                                        ->take(5)
                                        ->get() ?? [];
                                        
                                    if(count($recentReferrals) === 0) {
                                        // Sample data if no records found
                                        $recentReferrals = [
                                            ['id' => 'REF-1001', 'patient_name' => 'John Smith', 'referrer' => 'Dr. Harris', 'specialty' => 'Cardiology', 'status' => 'Completed', 'created_at' => now()->subDays(1)],
                                            ['id' => 'REF-1002', 'patient_name' => 'Emily Jones', 'referrer' => 'Dr. Patel', 'specialty' => 'Neurology', 'status' => 'Pending', 'created_at' => now()->subDays(2)],
                                            ['id' => 'REF-1003', 'patient_name' => 'Michael Brown', 'referrer' => 'Dr. Wilson', 'specialty' => 'Orthopedics', 'status' => 'Scheduled', 'created_at' => now()->subDays(3)],
                                            ['id' => 'REF-1004', 'patient_name' => 'Sarah Davis', 'referrer' => 'Dr. Roberts', 'specialty' => 'Gastroenterology', 'status' => 'Pending', 'created_at' => now()->subDays(4)],
                                            ['id' => 'REF-1005', 'patient_name' => 'David Miller', 'referrer' => 'Dr. Thompson', 'specialty' => 'Dermatology', 'status' => 'Scheduled', 'created_at' => now()->subDays(5)]
                                        ];
                                    }
                                @endphp
                                
                                @foreach($recentReferrals as $referral)
                                    <tr>
                                        <td>{{ $referral['id'] ?? $referral->id }}</td>
                                        <td>{{ $referral['patient_name'] ?? $referral->patient_name }}</td>
                                        <td>{{ $referral['referrer'] ?? ($referral->gp->name ?? 'Unknown') }}</td>
                                        <td>
                                            @php
                                                $specialty = $referral['specialty'] ?? ($referral->specialty ?? null);
                                                if (is_string($specialty)) {
                                                    echo $specialty;
                                                } elseif (is_object($specialty)) {
                                                    echo $specialty->name ?? 'Unknown';
                                                } elseif (is_array($specialty)) {
                                                    echo $specialty['name'] ?? 'Unknown';
                                                } else {
                                                    echo 'Unknown';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $status = $referral['status'] ?? $referral->status ?? 'Pending';
                                                $statusBadgeClass = 'badge badge-';
                                                
                                                switch($status) {
                                                    case 'Completed':
                                                        $statusBadgeClass .= 'success';
                                                        break;
                                                    case 'Scheduled':
                                                        $statusBadgeClass .= 'primary';
                                                        break;
                                                    case 'Pending':
                                                        $statusBadgeClass .= 'warning';
                                                        break;
                                                    default:
                                                        $statusBadgeClass .= 'info';
                                                }
                                            @endphp
                                            <span class="{{ $statusBadgeClass }}">{{ $status }}</span>
                                        </td>
                                        <td>{{ isset($referral->created_at) ? $referral->created_at->format('d M Y') : (isset($referral['created_at']) ? $referral['created_at']->format('d M Y') : 'N/A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="/admin/referrals" class="btn btn-sm btn-info float-right">View All Referrals</a>
                </div>
            </div>
        </div>

        <!-- System Stats -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">System Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="info-box mb-3 bg-light">
                        <span class="info-box-icon"><i class="fas fa-clinic-medical text-info"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clinics</span>
                            <span class="info-box-number">{{ \App\Models\Clinic::count() ?? 24 }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box mb-3 bg-light">
                        <span class="info-box-icon"><i class="fas fa-user-md text-success"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Consultants</span>
                            <span class="info-box-number">{{ \App\Models\Consultant::count() ?? 36 }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box mb-3 bg-light">
                        <span class="info-box-icon"><i class="fas fa-stethoscope text-warning"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Specialties</span>
                            <span class="info-box-number">{{ \App\Models\Specialty::count() ?? 15 }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box mb-3 bg-light">
                        <span class="info-box-icon"><i class="fas fa-clipboard-list text-danger"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Services</span>
                            <span class="info-box-number">{{ \App\Models\Service::count() ?? 28 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral & Revenue Analytics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monthly Referral Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="referralChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            // Monthly referral data - replace with real data from backend
            const monthlyData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Referrals',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: 3,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90, 85, 72, 65, 76, 52]
                    }
                ]
            };

            // Get context and create chart
            const referralChartCanvas = document.getElementById('referralChart').getContext('2d');
            new Chart(referralChartCanvas, {
                type: 'line',
                data: monthlyData,
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

        console.log('Admin dashboard loaded');
    </script>
@stop 