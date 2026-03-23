@extends('backend.layout.app')
@section('Title','Event Details')
@section('content')
{{-- Content body start --}}
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Event Details</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ Str::limit($event->title, 20) }}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $event->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Event Description</h4>
                                </div>
                                <div class="card-body">
                                    <p>{{ $event->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Event Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-responsive-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Organizer:</th>
                                                    <td>
                                                        @if($event->organizer)
                                                            <a href="{{ route('organizer.show', $event->organizer) }}">
                                                                {{ $event->organizer->name }}
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Date:</th>
                                                    <td>{{ $event->date->format('M d, Y h:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Location:</th>
                                                    <td>{{ $event->location ?? 'TBD' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge badge-{{
                                                            $event->status === 'published' ? 'success' :
                                                            ($event->status === 'cancelled' ? 'danger' :
                                                            ($event->status === 'completed' ? 'info' : 'warning'))
                                                            }}">
                                                            {{ ucfirst($event->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-secondary text-light">Back to Events</a>
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-primary text-light">Edit Event</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection