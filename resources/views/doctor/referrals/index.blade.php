@extends('adminlte::page')

@section('title', 'My Referrals')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>My Referrals</h1>
        <a href="{{ route('doctor.referrals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Create New Referral
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Hospital</th>
                            <th>Specialty</th>
                            <th>Consultant</th>
                            <th>Preferred Date</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($referrals as $referral)
                            <tr>
                                <td>{{ $referral->id }}</td>
                                <td>{{ $referral->patient_name }}</td>
                                <td>{{ $referral->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $referral->specialty->name ?? 'N/A' }}</td>
                                <td>{{ $referral->consultant->name ?? 'N/A' }}</td>
                                <td>{{ $referral->preferred_date->format('d/m/Y') }}</td>
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
                                <td>{{ $referral->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('doctor.referrals.show', $referral) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No referrals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $referrals->links() }}
            </div>
        </div>
    </div>
@stop 