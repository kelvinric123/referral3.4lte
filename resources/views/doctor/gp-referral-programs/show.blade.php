@extends('adminlte::page')

@section('title', 'Referral Program Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Referral Program Details</h1>
        <a href="{{ route('doctor.gp-referral-programs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Programs
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i> Information</h5>
            {{ session('info') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">{{ $gpReferralProgram->title }}</h2>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Program Information</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Publish Date:</strong> {{ $gpReferralProgram->publish_date->format('d M Y') }}</p>
                            
                            <div class="mt-3">
                                <h4>Description</h4>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($gpReferralProgram->description)) !!}
                                </div>
                            </div>
                            
                            @if($gpReferralProgram->youtube_link)
                                <div class="mt-4">
                                    <h4>Video</h4>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" 
                                                src="{{ str_replace('watch?v=', 'embed/', $gpReferralProgram->youtube_link) }}" 
                                                allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Program Participation</h3>
                        </div>
                        <div class="card-body">
                            @if($hasParticipated)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle mr-2"></i> You are already participating in this program.
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i> Register as a participant to earn <strong>20 loyalty points</strong>.
                                </div>
                                <form action="{{ route('doctor.gp-referral-programs.participate', $gpReferralProgram) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus mr-2"></i> Participate in this Program
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Program Attendance</h3>
                        </div>
                        <div class="card-body">
                            @if($hasAttended)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle mr-2"></i> Your attendance has been recorded for this program.
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i> Mark your attendance to earn additional <strong>40 loyalty points</strong>.
                                </div>
                                <form action="{{ route('doctor.gp-referral-programs.attend', $gpReferralProgram) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-calendar-check mr-2"></i> Mark Attendance
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@stop 