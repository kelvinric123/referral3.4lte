@extends('adminlte::page')

@section('title', 'Edit GP Referral Program')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit GP Referral Program</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gp-referral-programs.index') }}">GP Referral Programs</a></li>
                    <li class="breadcrumb-item active">Edit Program</li>
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
                        <h3 class="card-title">Edit GP Referral Program</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('admin.gp-referral-programs.update', $gpReferralProgram) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $gpReferralProgram->title) }}" required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $gpReferralProgram->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="publish_date">Publish Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ old('publish_date', $gpReferralProgram->publish_date->format('Y-m-d')) }}" required>
                                @error('publish_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube_link">YouTube Link</label>
                                <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" id="youtube_link" name="youtube_link" value="{{ old('youtube_link', $gpReferralProgram->youtube_link) }}" placeholder="https://www.youtube.com/watch?v=...">
                                @error('youtube_link')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Enter the full YouTube video URL.</small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $gpReferralProgram->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Program</button>
                            <a href="{{ route('admin.gp-referral-programs.index') }}" class="btn btn-default float-right">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>

        @if(session('success'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Success!</h5>
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- GP Participation -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Record GP Participation</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i> When a GP participates in this referral program, 
                            they will earn <strong>20 loyalty points</strong>.
                        </p>
                        
                        <form action="{{ route('admin.gp-referral-programs.participation', $gpReferralProgram) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select GPs who participated:</label>
                                <select class="form-control select2" name="gp_ids[]" multiple="multiple" data-placeholder="Select GPs" style="width: 100%;">
                                    @foreach($gps as $gp)
                                        <option value="{{ $gp->id }}">{{ $gp->name }} ({{ $gp->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Record Participation & Award Points</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Record GP Attendance</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i> When a GP attends this referral program, 
                            they will earn <strong>40 loyalty points</strong>. 
                            (They'll also be automatically marked as participated if not already)
                        </p>
                        
                        <form action="{{ route('admin.gp-referral-programs.attendance', $gpReferralProgram) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select GPs who attended:</label>
                                <select class="form-control select2" name="gp_ids[]" multiple="multiple" data-placeholder="Select GPs" style="width: 100%;">
                                    @foreach($gps as $gp)
                                        <option value="{{ $gp->id }}">{{ $gp->name }} ({{ $gp->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Record Attendance & Award Points</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- GP Participation and Attendance Lists -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">GP Participants</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>GP Name</th>
                                        <th>Email</th>
                                        <th>Participated On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->name }}</td>
                                            <td>{{ $participant->email }}</td>
                                            <td>{{ $participant->pivot->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No participants yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">GP Attendees</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>GP Name</th>
                                        <th>Email</th>
                                        <th>Attended On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendees as $attendee)
                                        <tr>
                                            <td>{{ $attendee->name }}</td>
                                            <td>{{ $attendee->email }}</td>
                                            <td>{{ $attendee->pivot->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No attendees yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function() {
            // Enable text editor for description field
            $('#description').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
            
            // Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            
            // Auto-hide success alerts after 5 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop 