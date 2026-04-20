@extends('backend.layout.app')
@section('Title', 'Reports & Analytics')
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
                <span><i class="mdi mdi-chart-bar"></i></span>
                <span class="ml-1">Reports & Analytics</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
            </ol>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success">
                            <i class="mdi mdi-account-multiple"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="mb-0">{{ $totalOrganizers }}</h4>
                            <p class="mb-0 text-muted">Total Organizers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
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

    <!-- Charts Row -->
    <div class="row">
        <!-- Events by Month Chart -->
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Events Overview - {{ date('Y') }}</h4>
                </div>
                <div class="card-body">
                    <canvas id="eventsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Events by Status -->
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Events by Status</h4>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Organizers and Locations -->
    <div class="row">
        <!-- Top Organizers -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Organizers</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Organizer Name</th>
                                    <th>Events Organized</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topOrganizers as $index => $organizer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $organizer->name }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $organizer->event_count }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('organizer.show', $organizer->id) }}" class="btn btn-sm btn-info text-light">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No organizers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events by Location -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Locations</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Location</th>
                                    <th>Events Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eventsByLocation as $index => $location)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $location->location }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $location->count }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No location data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming and Recent Events -->
    <div class="row">
        <!-- Upcoming Events -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Upcoming Events</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingEvents as $event)
                                    <tr>
                                        <td>
                                            <strong>{{ $event->title }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                @if($event->organizer)
                                                    by {{ $event->organizer->name }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ $event->date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ ucfirst($event->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No upcoming events.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Events -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recently Added Events</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Organizer</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEvents as $event)
                                    <tr>
                                        <td>
                                            <strong>{{ $event->title }}</strong>
                                        </td>
                                        <td>
                                            @if($event->organizer)
                                                {{ $event->organizer->name }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->date->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No events found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Report Links -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detailed Reports</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('reports.events') }}" class="btn btn-primary btn-block mb-3 text-white">
                                <i class="mdi mdi-calendar"></i> Events Report
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('reports.organizers') }}" class="btn btn-success btn-block mb-3 text-white">
                                <i class="mdi mdi-account-multiple"></i> Organizers Report
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-info btn-block mb-3 text-white" onclick="alert('Feature coming soon!')">
                                <i class="mdi mdi-download"></i> Export Report (PDF)
                            </a>
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
.icon-box.bg-info { background: linear-gradient(45deg, #00bcd4, #00acc1); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Events by Month Chart
    var eventsCtx = document.getElementById('eventsChart').getContext('2d');
    new Chart(eventsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Events',
                data: @json($monthlyEvents),
                backgroundColor: 'rgba(115, 102, 255, 0.2)',
                borderColor: 'rgba(115, 102, 255, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Events by Status Chart
    var statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Draft', 'Cancelled', 'Completed'],
            datasets: [{
                data: [
                    {{ $eventsByStatus['published'] ?? 0 }},
                    {{ $eventsByStatus['draft'] ?? 0 }},
                    {{ $eventsByStatus['cancelled'] ?? 0 }},
                    {{ $eventsByStatus['completed'] ?? 0 }}
                ],
                backgroundColor: [
                    '#11c15b',
                    '#f73164',
                    '#ff9f43',
                    '#00bcd4'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endsection
