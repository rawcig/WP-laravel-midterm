@extends('frontend.layout.app')
@section('title', 'Browse Events')
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

    <div class="row">
        @forelse($events as $event)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="text-muted">
                            <i class="mdi mdi-calendar"></i> {{ $event->date->format('M d, Y h:i A') }}
                        </p>
                        <p class="text-muted">
                            <i class="mdi mdi-map-marker"></i> {{ $event->location ?? 'TBA' }}
                        </p>
                        <p class="text-muted">
                            <i class="mdi mdi-account"></i> {{ $event->organizer ? $event->organizer->name : 'TBA' }}
                        </p>
                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                        <a href="{{ route('events.show.public', $event) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ route('events.register', $event) }}" class="btn btn-success">Register Now</a>
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
@endsection
