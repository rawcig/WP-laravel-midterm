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

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary">
                            <i class="mdi mdi-calendar"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $totalEvents }}</h4>
                            <p class="mb-0 text-muted">Total Events</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success">
                            <i class="mdi mdi-account-multiple"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $totalOrganizers }}</h4>
                            <p class="mb-0 text-muted">Organizers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning">
                            <i class="mdi mdi-calendar-check"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $upcomingEvents }}</h4>
                            <p class="mb-0 text-muted">Upcoming Events</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-info">
                            <i class="mdi mdi-account"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $totalUsers }}</h4>
                            <p class="mb-0 text-muted">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Events</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Event Title</th>
                                    <th scope="col">Organizer</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            @if($event->organizer)
                                                <a href="{{ route('organizer.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->date->format('M d, Y') }}</td>
                                        <td>{{ $event->location ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{
                                                $event->status === 'published' ? 'success' :
                                                ($event->status === 'cancelled' ? 'danger' :
                                                ($event->status === 'completed' ? 'info' : 'warning'))
                                                }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No events available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('create-event') }}" class="btn btn-primary btn-block mb-3">
                                <i class="mdi mdi-plus"></i> Create Event
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('organizer.create') }}" class="btn btn-success btn-block mb-3">
                                <i class="mdi mdi-account-plus"></i> Add Organizer
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('events.index') }}" class="btn btn-info btn-block mb-3">
                                <i class="mdi mdi-calendar"></i> View All Events
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('organizer.index') }}" class="btn btn-warning btn-block mb-3">
                                <i class="mdi mdi-account-multiple"></i> View Organizers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Events by Status</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $eventsByStatus['published'] ?? 0 }}</h3>
                                <p class="text-muted">Published</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-warning">{{ $eventsByStatus['draft'] ?? 0 }}</h3>
                                <p class="text-muted">Draft</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-danger">{{ $eventsByStatus['cancelled'] ?? 0 }}</h3>
                                <p class="text-muted">Cancelled</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-info">{{ $eventsByStatus['completed'] ?? 0 }}</h3>
                                <p class="text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 28px;
    color: white;
}
.icon-box.bg-primary { background: linear-gradient(45deg, #7366ff, #5c4dff); }
.icon-box.bg-success { background: linear-gradient(45deg, #11c15b, #0cae52); }
.icon-box.bg-warning { background: linear-gradient(45deg, #f73164, #e12a5a); }
.icon-box.bg-info { background: linear-gradient(45deg, #00bcd4, #00acc1); }
</style>
@endsection
