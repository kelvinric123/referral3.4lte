@extends('adminlte::page')

@section('title', 'GP Loyalty Points')

@section('content_header')
    <h1>GP Loyalty Points</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">GP Loyalty Points Summary</h3>
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
                            <th>GP Name</th>
                            <th>Clinic</th>
                            <th>Total Points</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gps as $gp)
                            <tr>
                                <td>{{ $gp->name }}</td>
                                <td>{{ $gp->clinic->name ?? 'N/A' }}</td>
                                <td>{{ $gp->totalPoints }}</td>
                                <td>
                                    @if($gp->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.gp-loyalty-points.show', $gp->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View Points History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No GPs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card bg-light mt-4">
        <div class="card-body">
            <h4>About GP Loyalty Points</h4>
            <p>GP loyalty points are awarded based on referral statuses:</p>
            <ul>
                <li>Points are earned when referrals progress through the system</li>
                <li>The highest points are awarded for completed referrals</li>
                <li>Total points represent the current balance for each GP</li>
                <li>View detailed point transaction history by clicking on "View Points History"</li>
            </ul>
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