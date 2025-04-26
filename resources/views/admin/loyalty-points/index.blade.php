@extends('adminlte::page')

@section('title', 'Loyalty Point Settings')

@section('content_header')
    <h1>Loyalty Point Settings</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">GP Loyalty Point Settings</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Points</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gpSettings as $setting)
                            <tr>
                                <td>{{ $setting->referral_status }}</td>
                                <td>{{ $setting->points }}</td>
                                <td>{{ $setting->description ?? 'N/A' }}</td>
                                <td>
                                    @if($setting->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.loyalty-point-settings.edit', $setting) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No GP loyalty point settings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Booking Agent Loyalty Point Settings</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Points</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingAgentSettings as $setting)
                            <tr>
                                <td>{{ $setting->referral_status }}</td>
                                <td>{{ $setting->points }}</td>
                                <td>{{ $setting->description ?? 'N/A' }}</td>
                                <td>
                                    @if($setting->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.loyalty-point-settings.edit', $setting) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Booking Agent loyalty point settings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card bg-light mt-4">
        <div class="card-body">
            <h4>Note:</h4>
            <p>Loyalty point settings define how many points are awarded for each referral status:</p>
            <ul>
                <li><strong>Pending:</strong> When a referral is initially created</li>
                <li><strong>Approved:</strong> When a referral is approved by hospital</li>
                <li><strong>Rejected:</strong> When a referral is rejected</li>
                <li><strong>No Show:</strong> When a patient doesn't attend the appointment</li>
                <li><strong>Completed:</strong> When a referral is completed</li>
                <li><strong>GP Referral Program Participated:</strong> When GP participated in the GP referral program</li>
                <li><strong>GP Referral Program Attended:</strong> When GP attended the GP referral program</li>
            </ul>
            <p>Settings cannot be deleted or created to maintain system consistency.</p>
            <p>GP Referral Program settings are connected to the <a href="{{ route('admin.gp-referral-programs.index') }}">GP Referral Programs</a> section.</p>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@stop 