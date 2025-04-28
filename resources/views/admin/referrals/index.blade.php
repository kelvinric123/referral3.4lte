@extends('adminlte::page')

@section('title', 'Referrals')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Referrals</h1>
        <a href="{{ route('admin.referrals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Referral
        </a>
    </div>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
        </div>
    @endif

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
            <form action="{{ route('admin.referrals.index') }}" method="GET">
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
                            <label for="hospital_id">Hospital</label>
                            <select class="form-control" id="hospital_id" name="hospital_id">
                                <option value="">All Hospitals</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name }}
                                    </option>
                                @endforeach
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
                            <label for="consultant_id">Consultant</label>
                            <select class="form-control" id="consultant_id" name="consultant_id">
                                <option value="">All Consultants</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{ $consultant->id }}" {{ request('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                        {{ $consultant->name }}
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
                </div>
                <div class="row">
                    <div class="col-md-3" id="gp_filter" style="{{ request('referrer_type') == 'GP' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="gp_id">GP Doctor</label>
                            <select class="form-control" id="gp_id" name="gp_id">
                                <option value="">All GPs</option>
                                @foreach($gps as $gp)
                                    <option value="{{ $gp->id }}" {{ request('gp_id') == $gp->id ? 'selected' : '' }}>
                                        {{ $gp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="booking_agent_filter" style="{{ request('referrer_type') == 'BookingAgent' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="booking_agent_id">Booking Agent</label>
                            <select class="form-control" id="booking_agent_id" name="booking_agent_id">
                                <option value="">All Booking Agents</option>
                                @foreach($bookingAgents as $agent)
                                    <option value="{{ $agent->id }}" {{ request('booking_agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
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
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.referrals.index') }}" class="btn btn-default">
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
            <h3 class="card-title">Referrals List</h3>
            <div class="card-tools">
                <div class="dropdown column-visibility-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-columns"></i> Columns
                    </button>
                    <div class="dropdown-menu dropdown-menu-right column-visibility-menu">
                        <div class="px-3 py-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="0" id="toggle-col-id" checked>
                                <label class="form-check-label" for="toggle-col-id">ID</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="1" id="toggle-col-patient" checked>
                                <label class="form-check-label" for="toggle-col-patient">Patient</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="2" id="toggle-col-hospital" checked>
                                <label class="form-check-label" for="toggle-col-hospital">Hospital</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="3" id="toggle-col-specialty" checked>
                                <label class="form-check-label" for="toggle-col-specialty">Specialty</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="4" id="toggle-col-consultant" checked>
                                <label class="form-check-label" for="toggle-col-consultant">Consultant</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="5" id="toggle-col-referrer" checked>
                                <label class="form-check-label" for="toggle-col-referrer">Referrer</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="6" id="toggle-col-date" checked>
                                <label class="form-check-label" for="toggle-col-date">Preferred Date</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="7" id="toggle-col-priority" checked>
                                <label class="form-check-label" for="toggle-col-priority">Priority</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="8" id="toggle-col-status" checked>
                                <label class="form-check-label" for="toggle-col-status">Status</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="9" id="toggle-col-created" checked>
                                <label class="form-check-label" for="toggle-col-created">Created</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input toggle-column" data-column="10" id="toggle-col-actions" checked>
                                <label class="form-check-label" for="toggle-col-actions">Actions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Hospital</th>
                            <th>Specialty</th>
                            <th>Consultant</th>
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
                                    <a href="{{ route('admin.referrals.show', $referral->id) }}">
                                        {{ $referral->patient_name }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ $referral->patient_id }}
                                    </div>
                                </td>
                                <td>{{ $referral->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $referral->specialty->name ?? 'N/A' }}</td>
                                <td>{{ $referral->consultant->name ?? 'N/A' }}</td>
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
                                        <span class="badge bg-primary">Completed</span>
                                    @endif
                                    
                                    <div class="dropdown d-inline ml-1">
                                        <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" id="statusDropdown{{ $referral->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Change
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="statusDropdown{{ $referral->id }}">
                                            <form action="{{ route('admin.referrals.update-status', $referral->id) }}" method="POST" class="status-form">
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
                                        <a href="{{ route('admin.referrals.show', $referral->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.referrals.edit', $referral->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.referrals.destroy', $referral->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this referral?');">
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
                                <td colspan="10" class="text-center">No referrals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $referrals->appends(request()->query())->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <style>
        .column-visibility-menu {
            min-width: 200px;
            padding: 10px;
        }
        .form-check {
            margin-bottom: 8px;
        }
        .btn-column-toggle {
            margin-left: 10px;
        }
        /* Keep dropdown menu open when clicking inside */
        .dropdown-menu.column-visibility-menu {
            cursor: default;
        }
        .dropdown-menu.column-visibility-menu.show {
            display: block;
        }
        .column-visibility-menu .form-check-input {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            setTimeout(function() {
                $('.form-control[id$="_id"]').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
            }, 100);
            
            // Toggle GP and Booking Agent filters based on referrer type
            $('#referrer_type').on('change', function() {
                var selectedType = $(this).val();
                
                if (selectedType === 'GP') {
                    $('#gp_filter').show();
                    $('#booking_agent_filter').hide();
                    $('#booking_agent_id').val('').trigger('change.select2');
                } else if (selectedType === 'BookingAgent') {
                    $('#booking_agent_filter').show();
                    $('#gp_filter').hide();
                    $('#gp_id').val('').trigger('change.select2');
                } else {
                    $('#gp_filter').hide();
                    $('#booking_agent_filter').hide();
                    $('#gp_id').val('').trigger('change.select2');
                    $('#booking_agent_id').val('').trigger('change.select2');
                }
            });
            
            // Initialize DataTable
            var table = $('.table').DataTable({
                "paging": false,  // We're using Laravel's pagination
                "ordering": true,
                "info": false,
                "searching": false, // We're using our own search filter
                "responsive": true,
                "autoWidth": false
            });
            
            // Keep the column visibility menu open when clicking inside it
            $('.column-visibility-menu').on('click', function(e) {
                e.stopPropagation();
            });
            
            // Column visibility controls
            $('.toggle-column').on('change', function() {
                var column = parseInt($(this).data('column'));
                var visible = $(this).prop('checked');
                toggleColumn(column, visible);
            });
            
            function toggleColumn(column, visible) {
                // Toggle visibility in the DOM directly
                $('table tr').each(function() {
                    $(this).find('th:eq(' + column + '), td:eq(' + column + ')').toggle(visible);
                });
                
                // Save preference
                saveColumnVisibilityPreferences();
            }
            
            // Function to save column visibility preferences
            function saveColumnVisibilityPreferences() {
                var preferences = {};
                $('.toggle-column').each(function() {
                    var column = $(this).data('column');
                    var visible = $(this).prop('checked');
                    preferences[column] = visible;
                });
                
                // Save to localStorage
                localStorage.setItem('referralsColumnVisibility', JSON.stringify(preferences));
            }
            
            // Load column visibility preferences
            function loadColumnVisibilityPreferences() {
                var preferences = localStorage.getItem('referralsColumnVisibility');
                if (preferences) {
                    try {
                        preferences = JSON.parse(preferences);
                        
                        $.each(preferences, function(column, visible) {
                            // Update checkbox state
                            $('.toggle-column[data-column="' + column + '"]').prop('checked', visible);
                            
                            // Apply visibility directly
                            toggleColumn(parseInt(column), visible);
                        });
                    } catch (e) {
                        console.error("Error loading column preferences:", e);
                        localStorage.removeItem('referralsColumnVisibility');
                    }
                }
            }
            
            // Initialize by loading saved preferences after a slight delay
            setTimeout(function() {
                loadColumnVisibilityPreferences();
            }, 200);
            
            // Confirmation dialog for status change
            $('.status-form button[type="submit"]').on('click', function(e) {
                e.preventDefault();
                
                var $button = $(this);
                var statusValue = $button.val();
                var referralId = $button.closest('form').attr('action').split('/').pop();
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
                    $button.closest('form').submit();
                }
            });
            
            // Add select all/none buttons for column visibility
            var columnControlsHtml = '<div class="mb-2">' +
                '<button type="button" class="btn btn-xs btn-primary mr-1" id="select-all-columns">Select All</button>' +
                '<button type="button" class="btn btn-xs btn-secondary" id="select-none-columns">Select None</button>' +
                '</div>';
            $('.column-visibility-menu .px-3').prepend(columnControlsHtml);
            
            // Select all columns
            $('#select-all-columns').on('click', function() {
                $('.toggle-column').prop('checked', true).each(function() {
                    toggleColumn(parseInt($(this).data('column')), true);
                });
            });
            
            // Select none columns
            $('#select-none-columns').on('click', function() {
                $('.toggle-column').prop('checked', false).each(function() {
                    toggleColumn(parseInt($(this).data('column')), false);
                });
            });
        });
    </script>
@stop 