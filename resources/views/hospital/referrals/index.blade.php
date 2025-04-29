@extends('adminlte::page')

@section('title', 'Referrals')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Referrals</h1>
        <a href="{{ route('hospital.referrals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Referral
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Referrals</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('hospital.referrals.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="No Show" {{ request('status') == 'No Show' ? 'selected' : '' }}>No Show</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="specialty_id">Specialty</label>
                            <select class="form-control" id="specialty_id" name="specialty_id">
                                <option value="">All Specialties</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ request('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="referrer_type">Referrer Type</label>
                            <select class="form-control" id="referrer_type" name="referrer_type">
                                <option value="">All Types</option>
                                <option value="GP" {{ request('referrer_type') == 'GP' ? 'selected' : '' }}>GP</option>
                                <option value="BookingAgent" {{ request('referrer_type') == 'BookingAgent' ? 'selected' : '' }}>Booking Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                placeholder="Patient name, ID..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="">All Priorities</option>
                                <option value="Normal" {{ request('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Urgent" {{ request('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="Emergency" {{ request('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('hospital.referrals.index') }}" class="btn btn-default">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $hospital->name }} - Referrals List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Specialty</th>
                            <th>Referrer</th>
                            <th>Preferred Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td>{{ $referral->id }}</td>
                                <td>
                                    <a href="{{ route('hospital.referrals.show', $referral->id) }}">
                                        {{ $referral->patient_name }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ $referral->patient_id }}
                                    </div>
                                </td>
                                <td>{{ $referral->specialty->name ?? 'N/A' }}</td>
                                <td>
                                    @if($referral->referrer_type == 'GP')
                                        <span class="badge bg-primary">GP</span>
                                        {{ $referral->gp->name ?? 'N/A' }}
                                    @elseif($referral->referrer_type == 'BookingAgent')
                                        <span class="badge bg-info">Agent</span>
                                        {{ $referral->bookingAgent->name ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {{ $referral->preferred_date ? date('d M Y', strtotime($referral->preferred_date)) : 'N/A' }}
                                </td>
                                <td>
                                    @if($referral->priority == 'Normal')
                                        <span class="badge bg-info">Normal</span>
                                    @elseif($referral->priority == 'Urgent')
                                        <span class="badge bg-warning">Urgent</span>
                                    @elseif($referral->priority == 'Emergency')
                                        <span class="badge bg-danger">Emergency</span>
                                    @endif
                                </td>
                                <td>
                                    @if($referral->status == 'Pending')
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif($referral->status == 'Approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($referral->status == 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($referral->status == 'No Show')
                                        <span class="badge bg-warning">No Show</span>
                                    @elseif($referral->status == 'Completed')
                                        <span class="badge bg-info">Completed</span>
                                    @endif
                                    
                                    <div class="dropdown d-inline ml-1">
                                        <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" id="statusDropdown{{ $referral->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Change
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="statusDropdown{{ $referral->id }}">
                                            <form action="{{ route('hospital.referrals.update-status', $referral->id) }}" method="POST" class="status-form">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if($referral->status == 'Pending')
                                                    {{-- From Pending, can only go to Approved or Rejected --}}
                                                    <button type="submit" name="status" value="Approved" class="dropdown-item">
                                                        <i class="fas fa-circle text-success mr-1"></i> Approve
                                                    </button>
                                                    
                                                    <button type="submit" name="status" value="Rejected" class="dropdown-item">
                                                        <i class="fas fa-circle text-danger mr-1"></i> Reject
                                                    </button>
                                                @elseif($referral->status == 'Approved')
                                                    {{-- From Approved, can only go to Completed or No Show --}}
                                                    <button type="submit" name="status" value="Completed" class="dropdown-item">
                                                        <i class="fas fa-circle text-primary mr-1"></i> Complete
                                                    </button>
                                                    
                                                    <button type="submit" name="status" value="No Show" class="dropdown-item">
                                                        <i class="fas fa-circle text-warning mr-1"></i> Mark as No Show
                                                    </button>
                                                @elseif(in_array($referral->status, ['Rejected', 'Completed', 'No Show']))
                                                    {{-- Final states, no further transitions --}}
                                                    <span class="dropdown-item-text text-muted">
                                                        <i class="fas fa-info-circle mr-1"></i> No further status changes allowed
                                                    </span>
                                                @else
                                                    {{-- Fallback for any unexpected status --}}
                                                    <button type="submit" name="status" value="Pending" class="dropdown-item">
                                                        <i class="fas fa-circle text-secondary mr-1"></i> Mark as Pending
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $referral->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('hospital.referrals.show', $referral->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('hospital.referrals.edit', $referral->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('hospital.referrals.destroy', $referral->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this referral?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Debug log
            console.log('Document ready, initializing status change handlers');
            
            // Handle status change form submission
            $('.status-form button[type="submit"]').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $button = $(this);
                var $form = $button.closest('form');
                var statusValue = $button.val();
                var referralId = $form.attr('action').split('/').pop();
                
                console.log('Status change clicked:', {
                    statusValue: statusValue,
                    referralId: referralId,
                    formAction: $form.attr('action')
                });
                
                var confirmMessage = 'Are you sure you want to change the status to ' + statusValue + '?';
                
                // Add context based on the status transition
                switch(statusValue) {
                    case 'Approved':
                        confirmMessage += '\n\nThis will move the referral forward in the process. Next steps will be to Complete it or mark as No Show.';
                        break;
                    case 'Rejected':
                        confirmMessage += '\n\nThis will mark the referral as rejected. This is a final state and cannot be changed later.';
                        break;
                    case 'Completed':
                        confirmMessage += '\n\nThis will award loyalty points to the referrer if applicable. This is a final state and cannot be changed later.';
                        break;
                    case 'No Show':
                        confirmMessage += '\n\nThis will mark the patient as not showing up for the appointment. This is a final state and cannot be changed later.';
                        break;
                }
                
                if (confirm(confirmMessage)) {
                    console.log('Submitting form...');
                    $form.submit();
                } else {
                    console.log('Status change cancelled');
                }
            });
            
            // Keep dropdowns open when clicking inside
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@stop 