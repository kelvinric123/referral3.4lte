@extends('adminlte::page')

@section('title', 'Booking Agent Loyalty Points Details')

@section('content_header')
    <h1>Booking Agent Loyalty Points for {{ $bookingAgent->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Booking Agent Details</h3>
            <div class="card-tools">
                <a href="{{ route('hospital.booking-agent-loyalty-points.index') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
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
                        
                        <dt class="col-sm-4">Phone:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->phone }}</dd>
                        
                        <dt class="col-sm-4">Position:</dt>
                        <dd class="col-sm-8">{{ $bookingAgent->position }}</dd>
                    </dl>
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
                                        <a href="{{ route('hospital.referrals.show', $point->referral->id) }}">
                                            #{{ $point->referral->id }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $point->status }}</td>
                                <td>{{ $point->points }}</td>
                                <td>{{ $point->balance }}</td>
                                <td>{{ $point->description }}</td>
                            </tr>
                        @endforeach
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
            $('.table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 