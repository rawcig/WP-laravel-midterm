@extends('backend.layout.app')
@section('Title', 'Admin Dashboard')
@section('CreateEvent')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('create-event') }}">Create Event</a>
    </li>
@endsection
@section('AddOrganizer')
    <li class="nav-item border-0">
        <a class="btn btn-secondary create-event-btn" href="{{ route('organizer.create') }}">Add Organizer</a>
    </li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="mdi mdi-speedometer"></i></span>
                <span class="ml-1">Dashboard</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3 class="mb-2">
                        <i class="mdi mdi-hand-wave"></i> 
                        Welcome back, {{ auth()->user()->name }}!
                    </h3>
                    <p class="mb-0">
                        <span class="badge badge-light text-primary">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <span class="ml-2">Here's what's happening with your events today.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Events Stats -->
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-calendar" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0">{{ $stats['total_events'] }}</h3>
                    <p class="mb-0">Total Events</p>
                    <hr class="my-2">
                    <small>
                        <i class="mdi mdi-check-circle"></i> {{ $stats['published_events'] }} Published
                        <br>
                        <i class="mdi mdi-clock"></i> {{ $stats['upcoming_events'] }} Upcoming
                    </small>
                </div>
            </div>
        </div>

        <!-- Organizers Stats -->
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-account-multiple" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0">{{ $stats['total_organizers'] }}</h3>
                    <p class="mb-0">Organizers</p>
                    <hr class="my-2">
                    <small>
                        <i class="mdi mdi-handshake"></i> Managing all events
                    </small>
                </div>
            </div>
        </div>

        <!-- Guests Stats -->
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-badge-account" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0">{{ $stats['total_guests'] }}</h3>
                    <p class="mb-0">Total Guests</p>
                    <hr class="my-2">
                    <small>
                        <i class="mdi mdi-check-circle"></i> {{ $stats['checked_in_guests'] }} Checked In
                    </small>
                </div>
            </div>
        </div>

        <!-- Users Stats -->
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="mdi mdi-account" style="font-size: 40px;"></i>
                    <h3 class="mt-2 mb-0">{{ $stats['total_users'] }}</h3>
                    <p class="mb-0">Users</p>
                    <hr class="my-2">
                    <small>
                        <i class="mdi mdi-shield-account"></i> {{ $stats['admin_users'] }} Admins
                        <br>
                        <i class="mdi mdi-handshake"></i> {{ $stats['organizer_users'] }} Organizers
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('create-event') }}" class="btn btn-primary btn-block">
                                <i class="mdi mdi-plus-circle"></i> Create Event
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('organizer.create') }}" class="btn btn-success btn-block">
                                <i class="mdi mdi-account-plus"></i> Add Organizer
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('guests.create') }}" class="btn btn-info btn-block text-white">
                                <i class="mdi mdi-badge-account"></i> Register Guest
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('reports.index') }}" class="btn btn-warning btn-block text-white">
                                <i class="mdi mdi-chart-bar"></i> View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Events -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="mdi mdi-calendar"></i> Recent Events</h5>
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentEvents->count() > 0)
                        <div class="list-group">
                            @foreach($recentEvents as $event)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        <small class="text-muted">{{ $event->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-muted small">
                                        <i class="mdi mdi-calendar"></i> {{ $event->date->format('M d, Y') }}
                                        @if($event->organizer)
                                            <i class="mdi mdi-account ml-2"></i> {{ $event->organizer->name }}
                                        @endif
                                    </p>
                                    <small>
                                        <span class="badge badge-{{
                                            $event->status === 'published' ? 'success' :
                                            ($event->status === 'cancelled' ? 'danger' :
                                            ($event->status === 'completed' ? 'info' : 'warning'))
                                        }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                        <span class="badge badge-secondary ml-1">
                                            <i class="mdi mdi-ticket"></i> {{ $event->guests->count() }} registered
                                        </span>
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No events yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Events by Registration -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="mdi mdi-trophy"></i> Popular Events</h5>
                    <a href="{{ route('reports.events') }}" class="btn btn-sm btn-primary">View Reports</a>
                </div>
                <div class="card-body">
                    @if($topEvents->count() > 0)
                        <div class="list-group">
                            @foreach($topEvents as $index => $event)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="badge badge-{{
                                                $index === 0 ? 'warning' :
                                                ($index === 1 ? 'secondary' :
                                                ($index === 2 ? 'brown' : 'light'))
                                            }} mr-2">#{{ $index + 1 }}</span>
                                            {{ $event->title }}
                                        </h6>
                                        <span class="badge badge-primary">
                                            <i class="mdi mdi-account"></i> {{ $event->guests_count }}
                                        </span>
                                    </div>
                                    <p class="mb-1 text-muted small">
                                        <i class="mdi mdi-calendar"></i> {{ $event->date->format('M d, Y') }}
                                        @if($event->location)
                                            <i class="mdi mdi-map-marker ml-2"></i> {{ Str::limit($event->location, 30) }}
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="mdi mdi-account-plus"></i> Recent Registrations</h5>
                    <a href="{{ route('guests.index') }}" class="btn btn-sm btn-primary">View All Guests</a>
                </div>
                <div class="card-body">
                    @if($recentGuests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Guest Name</th>
                                        <th>Email</th>
                                        <th>Event</th>
                                        <th>Type</th>
                                        <th>Tickets</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentGuests as $guest)
                                        <tr>
                                            <td>
                                                <strong>{{ $guest->name }}</strong>
                                                @if($guest->user)
                                                    <br><small class="text-muted">User #{{ $guest->user_id }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $guest->email }}</td>
                                            <td>
                                                <a href="{{ route('events.show', $guest->event) }}">
                                                    {{ Str::limit($guest->event->title, 40) }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{
                                                    $guest->participation_type === 'vip' ? 'danger' :
                                                    ($guest->participation_type === 'speaker' ? 'primary' :
                                                    ($guest->participation_type === 'sponsor' ? 'success' :
                                                    ($guest->participation_type === 'volunteer' ? 'info' : 'secondary')))
                                                }}">
                                                    {{ ucfirst($guest->participation_type) }}
                                                </span>
                                            </td>
                                            <td>{{ $guest->ticket_count }}</td>
                                            <td>
                                                <span class="badge badge-{{
                                                    $guest->registration_status === 'confirmed' ? 'success' :
                                                    ($guest->registration_status === 'cancelled' ? 'danger' :
                                                    ($guest->registration_status === 'attended' ? 'info' : 'warning'))
                                                }}">
                                                    {{ ucfirst($guest->registration_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $guest->created_at->diffForHumans() }}</small>
                                                <br>
                                                <small class="text-muted">{{ $guest->created_at->format('M d, h:i A') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No registrations yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.list-group-item {
    border-left: 3px solid transparent;
    transition: border-left-color 0.3s ease;
}

.list-group-item:hover {
    border-left-color: #7366ff;
}
</style>
@endsection
