@extends('frontend.layout.app')
@section('title', $event->title)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <h5>Event Description</h5>
                    <p>{{ $event->description }}</p>
                    
                    <div class="mt-4">
                        <h5>Event Details</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Date:</th>
                                <td>{{ $event->date->format('F d, Y \a\t h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Location:</th>
                                <td>{{ $event->location ?? 'TBA' }}</td>
                            </tr>
                            <tr>
                                <th>Organizer:</th>
                                <td>{{ $event->organizer ? $event->organizer->name : 'TBA' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><span class="badge badge-success">Published</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Register for this Event</h5>
                </div>
                <div class="card-body">
                    <p><i class="mdi mdi-calendar"></i> {{ $event->date->format('M d, Y') }}</p>
                    <p><i class="mdi mdi-map-marker"></i> {{ $event->location ?? 'TBA' }}</p>
                    <hr>
                    <a href="{{ route('events.register', $event) }}" class="btn btn-success btn-block btn-lg">
                        <i class="mdi mdi-account-plus"></i> Register Now
                    </a>
                    <p class="text-muted mt-3 text-center">
                        <small>Free registration • Limited seats available</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
