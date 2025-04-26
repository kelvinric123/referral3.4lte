@extends('adminlte::page')

@section('title', 'View GP Referral Program')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>GP Referral Program Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gp-referral-programs.index') }}">GP Referral Programs</a></li>
                    <li class="breadcrumb-item active">View Program</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $gpReferralProgram->title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.gp-referral-programs.edit', $gpReferralProgram) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.gp-referral-programs.index') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <h5 class="mb-3">Program Information</h5>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">ID:</div>
                                            <div class="col-md-8">{{ $gpReferralProgram->id }}</div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Title:</div>
                                            <div class="col-md-8">{{ $gpReferralProgram->title }}</div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Description:</div>
                                            <div class="col-md-8">
                                                @if($gpReferralProgram->description)
                                                    <div class="p-2 bg-white border rounded">
                                                        {!! $gpReferralProgram->description !!}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No description provided</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Publish Date:</div>
                                            <div class="col-md-8">{{ $gpReferralProgram->publish_date->format('F d, Y') }}</div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Status:</div>
                                            <div class="col-md-8">
                                                @if($gpReferralProgram->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Created At:</div>
                                            <div class="col-md-8">{{ $gpReferralProgram->created_at->format('F d, Y h:i A') }}</div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-bold">Last Updated:</div>
                                            <div class="col-md-8">{{ $gpReferralProgram->updated_at->format('F d, Y h:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                @if($gpReferralProgram->youtube_link)
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">YouTube Video</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                @php
                                                    // Extract video ID from YouTube URL
                                                    $videoId = '';
                                                    if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $gpReferralProgram->youtube_link, $matches)) {
                                                        $videoId = $matches[1];
                                                    }
                                                @endphp
                                                
                                                @if($videoId)
                                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                                                @else
                                                    <div class="text-center p-3">
                                                        <i class="fab fa-youtube fa-3x text-danger mb-3"></i>
                                                        <p>Invalid YouTube URL format</p>
                                                        <a href="{{ $gpReferralProgram->youtube_link }}" target="_blank" class="btn btn-danger">
                                                            <i class="fab fa-youtube"></i> Open in YouTube
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <div class="text-center py-5">
                                                <i class="fab fa-youtube fa-4x text-muted mb-3"></i>
                                                <p>No YouTube video linked to this program</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    
                    <div class="card-footer">
                        <form action="{{ route('admin.gp-referral-programs.destroy', $gpReferralProgram) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this program?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Program
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Any custom JS can go here
    </script>
@stop 