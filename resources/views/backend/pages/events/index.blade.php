@extends('backend.layout.app')
@section('Title', 'Events List')
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
{{-- Content body start --}}
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Events</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Events</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
               
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Organizer</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <th>{{ $event->id }}</th>
                                        <td>{{ $event->title }}</td>
                                        <td>
                                            @if($event->organizer)
                                                <a href="{{ route('organizer.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
                                            @else
                                                {{ $event->organizer ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>{{ $event->date->format('M d, Y h:i A') }}</td>
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
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary text-white">View</a>
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                            <a href="{{ route('events.guests', $event) }}" class="btn btn-sm btn-success text-white">
                                                <i class="mdi mdi-check-circle"></i> Check-in
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this event?')) this.closest('form').submit();" class="btn btn-sm btn-danger text-white">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No events available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection