@extends('adminlte::page')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Specialty Profiles')

@section('content_header')
    <h1>Specialty Profiles</h1>
    <p>View specialty information before referring patients</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Medical Specialties Available for Referrals</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="specialties-table">
                            <thead>
                                <tr>
                                    <th>Specialty Name</th>
                                    <th>Hospital</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($specialties as $specialtyItem)
                                    <tr>
                                        <td>{{ $specialtyItem->name }}</td>
                                        <td>{{ $specialtyItem->hospital->name ?? 'Not assigned' }}</td>
                                        <td>{{ Str::limit($specialtyItem->description, 50, '...') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#specialty-details-{{ $specialtyItem->id }}">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No specialties found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Specialty Detail Modals -->
    @foreach($specialties as $specialtyItem)
        <div class="modal fade" id="specialty-details-{{ $specialtyItem->id }}" tabindex="-1" role="dialog" aria-labelledby="specialtyDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="specialtyDetailsLabel">{{ $specialtyItem->name }} Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">Specialty Information</h6>
                                <p><strong>Name:</strong> {{ $specialtyItem->name }}</p>
                                <p><strong>Description:</strong> {{ $specialtyItem->description ?? 'No description available' }}</p>
                                <p><strong>Hospital:</strong> {{ $specialtyItem->hospital->name ?? 'Not assigned' }}</p>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">Hospital Details</h6>
                                @if(isset($specialtyItem->hospital))
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tr>
                                                <th>Hospital Name</th>
                                                <td>{{ $specialtyItem->hospital->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $specialtyItem->hospital->address ?? 'Not available' }}</td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td>{{ $specialtyItem->hospital->city ?? 'Not available' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $specialtyItem->hospital->phone ?? 'Not available' }}</td>
                                            </tr>
                                        </table>
                                        
                                        <a href="{{ route('doctor.referrals.create', ['hospital_id' => $specialtyItem->hospital_id, 'specialty_id' => $specialtyItem->id]) }}" class="btn btn-success mt-3">
                                            <i class="fas fa-file-medical"></i> Create Referral
                                        </a>
                                    </div>
                                @else
                                    <p>No hospital information available</p>
                                @endif
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
            $('#specialties-table').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Search specialty:",
                    "lengthMenu": "Show _MENU_ specialties per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ specialties"
                }
            });
        });
    </script>
@stop 