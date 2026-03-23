@extends('backend.layout.app')
@section('Title', 'Organizer Profile')
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
                <span><i class="mdi mdi-account"></i></span>
                <span class="ml-1">Organizer Details</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('organizer.index') }}">Organizers</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Organizer Details</a></li>
            </ol>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-md-5 col-xxl-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center mb-4">
                        <img class="mr-3 rounded-circle mr-0 mr-sm-3" src="{{ asset('images/avatar/avatar-media.png') }}" width="80" height="80" alt="">
                        <div class="media-body">
                            <h3 class="mb-0">{{ $organizer->name }}</h3>
                            <p class="text-muted mb-0">Organizer</p>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12 text-center">
                            <a href="{{ route('organizer.edit', $organizer) }}" class="btn btn-primary px-5">Edit Profile</a>
                        </div>
                    </div>

                    <h4>About Organizer</h4>
                    <p class="text-muted">{{ $organizer->description ?? 'No description available.' }}</p>
                    <ul class="card-profile__info">
                        @if($organizer->email)
                            <li class="mb-1"><strong class="text-dark mr-4">Email</strong> <span><a href="mailto:{{ $organizer->email }}">{{ $organizer->email }}</a></span></li>
                        @endif
                        @if($organizer->phone)
                            <li class="mb-1"><strong class="text-dark mr-4">Phone</strong> <span><a href="tel:{{ $organizer->phone }}">{{ $organizer->phone }}</a></span></li>
                        @endif
                        @if($organizer->website)
                            <li class="mb-1"><strong class="text-dark mr-4">Website</strong> <span><a href="{{ $organizer->website }}" target="_blank">{{ $organizer->website }}</a></span></li>
                        @endif
                    </ul>
                </div>
                <div class="card-footer border-0 pb-4">
                    <div class="card-action social-icons text-center">
                        <a class="facebook" href="javascript:void(0)"><span><i class="fa fa-facebook"></i></span></a>
                        <a class="twitter" href="javascript:void(0)"><span><i class="fa fa-twitter"></i></span></a>
                        <a class="youtube" href="javascript:void(0)"><span><i class="fa fa-youtube"></i></span></a>
                        <a class="googlePlus" href="javascript:void(0)"><span><i class="fa fa-google"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-md-7 col-xxl-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Events by {{ $organizer->name }}</h4>
                </div>
                <div class="card-body">
                    @if($organizer->events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organizer->events as $event)
                                        <tr>
                                            <th>{{ $event->id }}</th>
                                            <td>{{ $event->title }}</td>
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
                                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No events organized yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
