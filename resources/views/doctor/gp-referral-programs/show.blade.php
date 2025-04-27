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
                                        @php
                                            // Extract video ID from YouTube URL - more reliable method
                                            $videoId = null;
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $gpReferralProgram->youtube_link, $matches)) {
                                                $videoId = $matches[1];
                                            }
                                        @endphp
                                        
                                        @if($videoId)
                                            <iframe class="embed-responsive-item" 
                                                src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
                                                allowfullscreen 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                onerror="this.style.display='none'; document.getElementById('youtube-fallback-{{ $videoId }}').style.display='block';">
                                            </iframe>
                                            <div id="youtube-fallback-{{ $videoId }}" style="display:none;" class="text-center p-4 bg-light">
                                                <i class="fab fa-youtube fa-3x text-danger mb-3"></i>
                                                <p>The video couldn't be loaded. This may be due to YouTube's privacy settings or a temporary issue.</p>
                                                <a href="{{ $gpReferralProgram->youtube_link }}" target="_blank" class="btn btn-danger">
                                                    <i class="fab fa-youtube"></i> Open on YouTube
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-center p-4 bg-light">
                                                <i class="fab fa-youtube fa-3x text-danger mb-3"></i>
                                                <p>Invalid YouTube link format. Please open the video directly on YouTube.</p>
                                                <a href="{{ $gpReferralProgram->youtube_link }}" target="_blank" class="btn btn-danger">
                                                    <i class="fab fa-youtube"></i> Open on YouTube
                                                </a>
                                            </div>
                                        @endif
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
                                    <i class="fas fa-info-circle mr-2"></i> Attendance for this program will be recorded by administrators after the event.
                                </div>
                                <p class="text-muted">Once your attendance is confirmed by the administrator, you will receive 40 loyalty points.</p>
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
        
        // Handle YouTube iframe loading errors
        $('iframe.embed-responsive-item').on('error', function() {
            var iframe = $(this);
            var videoId = iframe.attr('src').split('/').pop().split('?')[0];
            iframe.hide();
            $('#youtube-fallback-' + videoId).show();
        });
    });
</script>
@stop 