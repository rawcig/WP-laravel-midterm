@extends('backend.layout.app')
@section('Title', 'Create Event')
@section('AddOrganizer')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('organizer.create') }}">Add Organizer</a>
    </li>
@endsection
@section('content')
{{-- Content body start --}}
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Create Event</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Event</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Event</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('events.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Event Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title') }}" placeholder="Enter event title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Organizer *</label>
                                    <select name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" required>
                                        <option value="">Select Organizer</option>
                                        @if ($organizers->isEmpty())
                                            
                                           
                                                <option value="" disabled>No organizers available</option>
                                        @else
                                            @foreach ($organizers as $organizer)
                                                <option value="{{ $organizer->name }}" {{ old('organizer') == $organizer->name ? 'selected' : '' }}>
                                                    {{ $organizer->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="4" placeholder="Enter event description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Cover Image</label>
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                       name="cover_image" accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 1200x600px (JPG, PNG)</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Event Date *</label>
                                    <input type="datetime-local" class="form-control @error('date') is-invalid @enderror"
                                           name="date" value="{{ old('date') }}" required min="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                           name="location" value="{{ old('location') }}" placeholder="Enter event location">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Max Attendees</label>
                                    <input type="number" class="form-control @error('max_attendees') is-invalid @enderror"
                                           name="max_attendees" value="{{ old('max_attendees') }}" placeholder="Leave empty for unlimited" min="1">
                                    @error('max_attendees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave empty for unlimited</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="">Select status</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                            <a href="{{ route('events.index') }}" class="btn btn-danger text-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

