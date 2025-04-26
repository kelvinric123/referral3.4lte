@extends('adminlte::page')

@section('title', 'My Loyalty Points')

@section('content_header')
    <h1>My Loyalty Points</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-award mr-2"></i> Loyalty Points Summary
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box bg-gradient-success">
                                <span class="info-box-icon"><i class="fas fa-star"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Points</span>
                                    <span class="info-box-number">{{ $totalPoints }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Completed</span>
                                    <span class="info-box-number">{{ $pointsByStatus['Completed'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Approved</span>
                                    <span class="info-box-number">{{ $pointsByStatus['Approved'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box bg-gradient-warning">
                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending</span>
                                    <span class="info-box-number">{{ $pointsByStatus['Pending'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i> Points Transaction History
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Points</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loyaltyPoints as $point)
                                    <tr>
                                        <td>{{ $point->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @if ($point->points > 0)
                                                <span class="text-success">+{{ $point->points }}</span>
                                            @elseif ($point->points < 0)
                                                <span class="text-danger">{{ $point->points }}</span>
                                            @else
                                                <span class="text-muted">{{ $point->points }}</span>
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
                                                    <span class="badge badge-info">{{ $point->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $point->description }}</td>
                                        <td>{{ $point->balance }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No loyalty points transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $loyaltyPoints->links() }}
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i> Monthly Points
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="monthlyPointsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i> How to Earn Points
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Creating a Referral
                            <span class="badge badge-primary badge-pill">10 points</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Referral Approved
                            <span class="badge badge-primary badge-pill">20 points</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Referral Completed
                            <span class="badge badge-primary badge-pill">50 points</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        // Monthly Points Chart
        var ctx = document.getElementById('monthlyPointsChart').getContext('2d');
        var months = @json(array_keys($monthlyPoints));
        var pointValues = @json(array_values($monthlyPoints));
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Points Earned',
                    data: pointValues,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
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