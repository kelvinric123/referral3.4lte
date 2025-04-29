@extends('adminlte::page')

@section('title', 'Hospital Profiles')

@section('content_header')
    <h1>Hospital Profiles</h1>
    <p>View hospital information before referring patients</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hospitals Available for Referrals</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="hospitals-table">
                            <thead>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hospitals as $hospitalItem)
                                    <tr>
                                        <td>{{ $hospitalItem->name }}</td>
                                        <td>{{ $hospitalItem->address }}</td>
                                        <td>{{ $hospitalItem->city }}</td>
                                        <td>{{ $hospitalItem->phone }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#hospital-details-{{ $hospitalItem->id }}">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hospitals found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hospital Detail Modals -->
    @foreach($hospitals as $hospitalItem)
        <div class="modal fade" id="hospital-details-{{ $hospitalItem->id }}" tabindex="-1" role="dialog" aria-labelledby="hospitalDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="hospitalDetailsLabel">{{ $hospitalItem->name }} Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Contact Information</h6>
                                <p><strong>Address:</strong> {{ $hospitalItem->address }}</p>
                                <p><strong>City:</strong> {{ $hospitalItem->city }}</p>
                                <p><strong>Postcode:</strong> {{ $hospitalItem->postcode }}</p>
                                <p><strong>Phone:</strong> {{ $hospitalItem->phone }}</p>
                                <p><strong>Email:</strong> {{ $hospitalItem->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Hospital Information</h6>
                                <p><strong>Type:</strong> {{ $hospitalItem->type ?? 'Not specified' }}</p>
                                <p><strong>Beds:</strong> {{ $hospitalItem->beds ?? 'Not specified' }}</p>
                                <p><strong>Established:</strong> {{ $hospitalItem->established_year ?? 'Not specified' }}</p>
                            </div>
                        </div>
                        
                        @if(isset($hospitalItem->description) && !empty($hospitalItem->description))
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">About</h6>
                                <p>{{ $hospitalItem->description }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('doctor.referrals.create', ['hospital_id' => $hospitalItem->id]) }}" class="btn btn-success">
                                    <i class="fas fa-file-medical"></i> Create Referral to This Hospital
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hospitals-table').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Search hospital:",
                    "lengthMenu": "Show _MENU_ hospitals per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ hospitals"
                }
            });
        });
    </script>
@stop 