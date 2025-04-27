@extends('adminlte::page')

@section('title', 'Referrals Directory')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Referrals Directory</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Referrals</h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Filter by Status
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="{{ route('hospital.referrals.index') }}" class="dropdown-item">All Status</a>
                        <a href="{{ route('hospital.referrals.index', ['status' => 'pending']) }}" class="dropdown-item">Pending</a>
                        <a href="{{ route('hospital.referrals.index', ['status' => 'approved']) }}" class="dropdown-item">Approved</a>
                        <a href="{{ route('hospital.referrals.index', ['status' => 'rejected']) }}" class="dropdown-item">Rejected</a>
                        <a href="{{ route('hospital.referrals.index', ['status' => 'completed']) }}" class="dropdown-item">Completed</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(isset($referrals) && $referrals->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i> No referrals available.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>GP</th>
                                <th>Patient</th>
                                <th>Service</th>
                                <th>Consultant</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referrals as $referral)
                                <tr>
                                    <td>{{ $referral->id }}</td>
                                    <td>{{ $referral->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($referral->gp)
                                            <a href="{{ route('hospital.gps.show', $referral->gp) }}">
                                                {{ $referral->gp->name }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $referral->patient_name }}</td>
                                    <td>
                                        @if($referral->service)
                                            {{ $referral->service->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($referral->consultant)
                                            <a href="{{ route('hospital.consultants.show', $referral->consultant) }}">
                                                {{ $referral->consultant->name }}
                                            </a>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td>
                                        @if($referral->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($referral->status == 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($referral->status == 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @elseif($referral->status == 'completed')
                                            <span class="badge badge-info">Completed</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($referral->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('hospital.referrals.show', $referral) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 