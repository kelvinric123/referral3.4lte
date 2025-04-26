@extends('adminlte::page')

@section('title', 'Booking Agent Loyalty Points History')

@section('content_header')
    <h1>Booking Agent Loyalty Points History</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Booking Agent Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 120px;">Name</th>
                            <td>{{ $bookingAgent->name }}</td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <td>{{ $bookingAgent->company->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($bookingAgent->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Loyalty Points</span>
                            <span class="info-box-number h2">
                                {{ count($loyaltyPoints) > 0 ? $loyaltyPoints->first()->balance : 0 }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Loyalty Points Transaction History</h3>
            <div class="card-tools">
                <a href="{{ route('admin.booking-agent-loyalty-points.index') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Referral ID</th>
                            <th>Status</th>
                            <th>Points</th>
                            <th>Description</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loyaltyPoints as $point)
                            <tr>
                                <td>{{ $point->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if($point->referral)
                                        <a href="{{ route('admin.referrals.show', $point->referral_id) }}">
                                            #{{ $point->referral_id }}
                                        </a>
                                    @else
                                        #{{ $point->referral_id }}
                                    @endif
                                </td>
                                <td>
                                    @if($point->status == 'Pending')
                                        <span class="badge badge-secondary">Pending</span>
                                    @elseif($point->status == 'Approved')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($point->status == 'Rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                    @elseif($point->status == 'No Show')
                                        <span class="badge badge-warning">No Show</span>
                                    @elseif($point->status == 'Completed')
                                        <span class="badge badge-primary">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($point->points > 0)
                                        <span class="text-success">+{{ $point->points }}</span>
                                    @elseif($point->points < 0)
                                        <span class="text-danger">{{ $point->points }}</span>
                                    @else
                                        {{ $point->points }}
                                    @endif
                                </td>
                                <td>{{ $point->description }}</td>
                                <td>{{ $point->balance }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No loyalty points history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Any JS functionality can be added here
        });
    </script>
@stop 