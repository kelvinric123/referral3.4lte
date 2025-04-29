@extends('adminlte::page')

@section('title', 'Consultant Profiles')

@section('content_header')
    <h1>Consultant Profiles</h1>
    <p>View consultant information before referring patients</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Consultants Available for Referrals</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hospital-filter">Filter by Hospital</label>
                                <select class="form-control" id="hospital-filter">
                                    <option value="">All Hospitals</option>
                                    @foreach($consultants->pluck('hospital.name')->unique()->filter() as $hospitalName)
                                        <option value="{{ $hospitalName }}">{{ $hospitalName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="specialty-filter">Filter by Specialty</label>
                                <select class="form-control" id="specialty-filter">
                                    <option value="">All Specialties</option>
                                    @foreach($consultants->pluck('specialty.name')->unique()->filter() as $specialtyName)
                                        <option value="{{ $specialtyName }}">{{ $specialtyName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name-filter">Search by Name</label>
                                <input type="text" class="form-control" id="name-filter" placeholder="Enter consultant name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button id="reset-filters" class="btn btn-secondary btn-block">Reset Filters</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="consultants-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specialty</th>
                                    <th>Hospital</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultants as $consultantItem)
                                    <tr data-hospital="{{ $consultantItem->hospital->name ?? '' }}" 
                                        data-specialty="{{ $consultantItem->specialty->name ?? '' }}"
                                        data-name="{{ $consultantItem->name }}">
                                        <td>{{ $consultantItem->name }}</td>
                                        <td>{{ $consultantItem->specialty->name ?? 'Not assigned' }}</td>
                                        <td>{{ $consultantItem->hospital->name ?? 'Not assigned' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#consultant-details-{{ $consultantItem->id }}">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No consultants found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultant Detail Modals -->
    @foreach($consultants as $consultantItem)
        <div class="modal fade" id="consultant-details-{{ $consultantItem->id }}" tabindex="-1" role="dialog" aria-labelledby="consultantDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="consultantDetailsLabel">{{ $consultantItem->name }} Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Contact Information</h6>
                                <p><strong>Email:</strong> {{ $consultantItem->email }}</p>
                                <p><strong>Phone:</strong> {{ $consultantItem->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Professional Information</h6>
                                <p><strong>Specialty:</strong> {{ $consultantItem->specialty->name ?? 'Not assigned' }}</p>
                                <p><strong>Hospital:</strong> {{ $consultantItem->hospital->name ?? 'Not assigned' }}</p>
                            </div>
                        </div>
                        
                        @if(isset($consultantItem->qualifications) && !empty($consultantItem->qualifications))
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">Qualifications</h6>
                                <p>{{ $consultantItem->qualifications }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($consultantItem->biography) && !empty($consultantItem->biography))
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">Biography</h6>
                                <p>{{ $consultantItem->biography }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('doctor.referrals.create', ['hospital_id' => $consultantItem->hospital_id, 'specialty_id' => $consultantItem->specialty_id, 'consultant_id' => $consultantItem->id]) }}" class="btn btn-success">
                                    <i class="fas fa-file-medical"></i> Create Referral to This Consultant
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
            // Initialize DataTable
            var table = $('#consultants-table').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Search consultant:",
                    "lengthMenu": "Show _MENU_ consultants per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ consultants"
                }
            });

            // Custom filtering function
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var hospitalFilter = $('#hospital-filter').val().toLowerCase();
                    var specialtyFilter = $('#specialty-filter').val().toLowerCase();
                    var nameFilter = $('#name-filter').val().toLowerCase();
                    
                    var row = table.row(dataIndex).node();
                    var hospital = $(row).data('hospital').toLowerCase();
                    var specialty = $(row).data('specialty').toLowerCase();
                    var name = $(row).data('name').toLowerCase();
                    
                    if (hospitalFilter && hospital !== hospitalFilter) {
                        return false;
                    }
                    
                    if (specialtyFilter && specialty !== specialtyFilter) {
                        return false;
                    }
                    
                    if (nameFilter && !name.includes(nameFilter)) {
                        return false;
                    }
                    
                    return true;
                }
            );

            // Apply filters when changed
            $('#hospital-filter, #specialty-filter, #name-filter').on('keyup change', function() {
                table.draw();
            });

            // Reset filters
            $('#reset-filters').on('click', function() {
                $('#hospital-filter, #specialty-filter').val('');
                $('#name-filter').val('');
                table.draw();
            });
        });
    </script>
@stop 