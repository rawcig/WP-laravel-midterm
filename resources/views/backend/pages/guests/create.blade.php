@extends('backend.layout.app')
@section('Title', 'Register Guest')
@section('CreateEvent')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('create-event') }}">Create Event</a>
    </li>
@endsection
@section('AddGuest')
    <li class="nav-item border-0">
        <a class="btn btn-success create-event-btn" href="{{ route('guests.create') }}">Register Guest</a>
    </li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-account-plus"></i></span>
                <span class="ml-1">Register Guest</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guests.index') }}">Guests</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Register Guest</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Event Registration Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('guests.store') }}" method="POST">
                        @csrf
                        
                        <h5 class="mb-3">Personal Information</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Company/Organization</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror"
                                       name="company" value="{{ old('company') }}" placeholder="Enter company name">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Position/Title</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       name="position" value="{{ old('position') }}" placeholder="Enter your position">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Event *</label>
                                <select name="event_id" class="form-control @error('event_id') is-invalid @enderror" required>
                                    <option value="">Select Event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" 
                                            {{ old('event_id') == $event->id || (isset($selectedEventId) && $selectedEventId == $event->id) ? 'selected' : '' }}>
                                            {{ $event->title }} - {{ $event->date->format('M d, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Registration Details</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Participation Type *</label>
                                <select name="participation_type" class="form-control @error('participation_type') is-invalid @enderror" required>
                                    <option value="">Select type</option>
                                    <option value="attendee" {{ old('participation_type') == 'attendee' ? 'selected' : '' }}>Attendee</option>
                                    <option value="speaker" {{ old('participation_type') == 'speaker' ? 'selected' : '' }}>Speaker</option>
                                    <option value="sponsor" {{ old('participation_type') == 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                                    <option value="volunteer" {{ old('participation_type') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                    <option value="vip" {{ old('participation_type') == 'vip' ? 'selected' : '' }}>VIP Guest</option>
                                </select>
                                @error('participation_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Specify the person's role in the event</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Number of Tickets *</label>
                                <input type="number" class="form-control @error('ticket_count') is-invalid @enderror"
                                       name="ticket_count" value="{{ old('ticket_count', 1) }}" min="1" max="10" required>
                                @error('ticket_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Maximum 10 tickets per registration</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Dietary Requirements</label>
                            <textarea class="form-control @error('dietary_requirements') is-invalid @enderror"
                                      name="dietary_requirements" rows="2" placeholder="Any dietary restrictions or food allergies...">{{ old('dietary_requirements') }}</textarea>
                            @error('dietary_requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      name="notes" rows="3" placeholder="Any additional information...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-check"></i> Complete Registration
                            </button>
                            <a href="javascript:history.back()" class="btn btn-danger text-light">
                                <i class="mdi mdi-close"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-xl-4 col-xxl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Registration Info</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="mdi mdi-information"></i> Participation Types:</h6>
                        <ul class="mb-0 pl-3">
                            <li><strong>Attendee</strong> - Regular participant</li>
                            <li><strong>Speaker</strong> - Event speaker/presenter</li>
                            <li><strong>Sponsor</strong> - Event sponsor</li>
                            <li><strong>Volunteer</strong> - Event volunteer/staff</li>
                            <li><strong>VIP</strong> - Special guest</li>
                        </ul>
                    </div>
                    
                    <div class="mt-3">
                        <h6><i class="mdi mdi-check-circle"></i> What happens next?</h6>
                        <ol class="mb-0 pl-3">
                            <li>Registration is confirmed</li>
                            <li>Guest appears in event guest list</li>
                            <li>Can be checked-in on event day</li>
                            <li>Attendance will be tracked</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
