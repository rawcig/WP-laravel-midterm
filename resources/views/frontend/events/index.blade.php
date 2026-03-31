@extends('backend.layout.app')
@section('Title', 'Browse Events')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-calendar"></i></span>
                <span class="ml-1">Browse Events</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Events</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    @if(auth()->check())
        @php
            $myEventIds = auth()->user()->guests()->pluck('event_id');
        @endphp

        @if($myEventIds->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5><i class="mdi mdi-ticket"></i> Your Registered Events</h5>
                        <p class="mb-0">
                            You are registered for {{ $myEventIds->count() }} event(s). 
                            <a href="{{ route('my-events') }}">View all my events →</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="row">
        @forelse($events as $event)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card event-card h-100">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}" 
                             class="card-img-top" alt="{{ $event->title }}" 
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        
                        <!-- Registration Status Badge -->
                        @php
                            $userRegistration = auth()->check() ? $event->getUserRegistration() : null;
                        @endphp
                        
                        @if($userRegistration)
                            <span class="badge badge-success mb-2">
                                <i class="mdi mdi-check-circle"></i> Registered
                            </span>
                        @elseif(auth()->check())
                            <span class="badge badge-primary mb-2">
                                <i class="mdi mdi-plus-circle"></i> Available to Register
                            </span>
                        @else
                            <span class="badge badge-info mb-2">
                                <i class="mdi mdi-login"></i> Login to Register
                            </span>
                        @endif
                        
                        <!-- Seat Availability -->
                        <div class="mb-2">
                            @if(is_null($event->max_attendees))
                                <span class="badge badge-info">
                                    <i class="mdi mdi-infinity"></i> Unlimited Seats
                                </span>
                            @elseif($event->is_full)
                                <span class="badge badge-danger">
                                    <i class="mdi mdi-close-circle"></i> Sold Out
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="mdi mdi-check-circle"></i> 
                                    {{ $event->available_seats }} seats left
                                </span>
                            @endif
                        </div>
                        
                        <!-- Event Info -->
                        <p class="text-muted mb-1">
                            <i class="mdi mdi-calendar"></i> 
                            {{ $event->date->format('M d, Y h:i A') }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="mdi mdi-map-marker"></i> 
                            {{ $event->location ?? 'TBA' }}
                        </p>
                        <p class="text-muted mb-1">
                            <i class="mdi mdi-account"></i> 
                            {{ $event->organizer ? $event->organizer->name : 'TBA' }}
                        </p>
                        
                        <!-- Attendance Stats -->
                        <div class="row mt-3 mb-2">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="mdi mdi-account-multiple"></i> 
                                    {{ $event->registered_count }} registered
                                </small>
                            </div>
                            <div class="col-6 text-right">
                                <small class="text-muted">
                                    <i class="mdi mdi-ticket"></i> 
                                    {{ $event->ticket_count }} tickets
                                </small>
                            </div>
                        </div>
                        
                        @if($event->max_attendees)
                            <div class="progress mb-3" style="height: 8px;">
                                @php
                                    $percentage = min(100, ($event->ticket_count / $event->max_attendees) * 100);
                                @endphp
                                <div class="progress-bar bg-{{ $event->is_full ? 'danger' : ($percentage > 80 ? 'warning' : 'success') }}" 
                                     role="progressbar" 
                                     style="width: {{ $percentage }}%">
                                </div>
                            </div>
                        @endif
                        
                        <p class="card-text">{{ Str::limit($event->description, 80) }}</p>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3">
                            <a href="{{ route('events.show.public', $event) }}" 
                               class="btn btn-primary btn-block text-white">
                                <i class="mdi mdi-eye"></i> View Details
                            </a>
                            
                            @if($userRegistration)
                                <a href="{{ route('my-events') }}" 
                                   class="btn btn-success btn-block mt-2 text-white">
                                    <i class="mdi mdi-ticket"></i> View My Ticket
                                </a>
                            @elseif(auth()->check() && !$event->is_full)
                                <a href="{{ route('events.register', $event) }}" 
                                   class="btn btn-success btn-block mt-2 text-white">
                                    <i class="mdi mdi-account-plus"></i> Register Now
                                </a>
                            @elseif($event->is_full)
                                <button class="btn btn-secondary btn-block mt-2" disabled>
                                    <i class="mdi mdi-close-circle"></i> Event Full
                                </button>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="btn btn-info btn-block mt-2 text-white">
                                    <i class="mdi mdi-login"></i> Login to Register
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="mdi mdi-information"></i> No upcoming events available at the moment.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $events->links() }}
    </div>
</div>

<style>
.event-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.event-card img.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
</style>
@endsection
