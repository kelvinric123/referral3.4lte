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
        });
    </script>
@stop 