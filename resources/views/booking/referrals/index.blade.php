@extends('adminlte::page')

@section('title', 'My Referrals')

@section('content_header')
    <h1>My Referrals</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Referrals List</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking.referrals.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Referral
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($referrals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Referral #</th>
                                        <th>Patient Name</th>
                                        <th>Hospital</th>
                                        <th>Specialty</th>
                                        <th>Status</th>
                                        <th>Urgency</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td>REF-{{ $referral->id }}</td>
                                            <td>{{ $referral->patient_name }}</td>
                                            <td>{{ $referral->hospital->name ?? 'N/A' }}</td>
                                            <td>{{ $referral->specialty->name ?? 'N/A' }}</td>
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
                                            <td>
                                                @switch($referral->priority)
                                                    @case('Emergency')
                                                        <span class="badge badge-danger">Emergency</span>
                                                        @break
                                                    @case('Urgent')
                                                        <span class="badge badge-warning">Urgent</span>
                                                        @break
                                                    @case('Normal')
                                                        <span class="badge badge-success">Normal</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-info">{{ $referral->priority }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $referral->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('booking.referrals.show', $referral) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @if($referral->status === 'Pending')
                                                    <a href="{{ route('booking.referrals.edit', $referral) }}" class="btn btn-sm btn-primary ml-1">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('booking.referrals.cancel', $referral) }}" method="POST" class="d-inline ml-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this referral?')">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $referrals->links() }}
                        </div>
                    @else
                        <div class="text-center">
                            <p>No referrals found.</p>
                            <a href="{{ route('booking.referrals.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Your First Referral
                            </a>
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
    <script> console.log('Booking Agent Referrals loaded'); </script>
@stop 