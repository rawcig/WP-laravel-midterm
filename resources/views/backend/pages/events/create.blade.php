@extends('backend.layout.app')
@section('Title', 'Create Event')
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
                <span class="ml-1">Create Event</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Event</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-8 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Event</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Event Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" id="eventTitle" value="{{ old('title') }}" placeholder="Enter event title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Organizer *</label>
                                    <select name="organizer" id="eventOrganizer" class="form-control @error('organizer') is-invalid @enderror" required>
                                        <option value="">Select Organizer</option>
                                        @if ($organizers->isEmpty())
                                            
                                           
                                                <option value="" disabled>No organizers available</option>
                                        @else
                                            @foreach ($organizers as $organizer)
                                                <option value="{{ $organizer->name }}" {{ old('organizer') == $organizer->name ? 'selected' : '' }}>
                                                    {{ $organizer->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" id="eventDescription" rows="4" placeholder="Enter event description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Cover Image</label>
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                       name="cover_image" id="coverImage" accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 1200x600px (JPG, PNG)</small>
                            </div>
                            <div class="form-group">
                                <label>Detail Image</label>
                                <input type="file" class="form-control @error('detail_image') is-invalid @enderror"
                                       name="detail_image" accept="image/*">
                                @error('detail_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 800x600px (JPG, PNG, max 5MB)</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Event Date *</label>
                                    <input type="datetime-local" class="form-control @error('date') is-invalid @enderror"
                                           name="date" id="eventDate" value="{{ old('date') }}" required min="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                           name="location" id="eventLocation" value="{{ old('location') }}" placeholder="Enter event location">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Max Attendees</label>
                                    <input type="number" class="form-control @error('max_attendees') is-invalid @enderror"
                                           name="max_attendees" value="{{ old('max_attendees') }}" placeholder="Leave empty for unlimited" min="1">
                                    @error('max_attendees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave empty for unlimited</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="eventStatus" required>
                                        <option value="">Select status</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                            <a href="{{ route('events.index') }}" class="btn btn-danger text-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="col-xl-4 col-xxl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="mdi mdi-eye"></i> Live Preview</h4>
                    <small class="text-muted">See how your event will look</small>
                </div>
                <div class="card-body">
                    <!-- Preview Event Card -->
                    <div class="card mb-3" id="previewCard">
                        <div class="event-image-container" id="previewImageContainer" data-image="{{ asset('images/placeholder-event.svg') }}">
                            <img class="card-img-top img-fluid" id="previewImage" src="{{ asset('images/placeholder-event.svg') }}"
                                 alt="Event Preview" style="max-height: 200px; object-fit: contain; width: 100%; position: relative; z-index: 1;">
                        </div>
                        <div class="card-header text-white">
                            <h5 class="mb-0" id="previewTitle">Event Title</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text" id="previewDescription">Event description will appear here...</p>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="mdi mdi-calendar"></i>
                                        <span id="previewDate">Date</span>
                                    </small>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-muted">
                                        <i class="mdi mdi-map-marker"></i>
                                        <span id="previewLocation">Location</span>
                                    </small>
                                </div>
                            </div>
                            <div class="mt-1">
                                <small class="text-muted">
                                    <i class="mdi mdi-account"></i>
                                    <span id="previewOrganizer">Organizer</span>
                                </small>
                            </div>

                            <div class="mt-3">
                                <span class="badge" id="previewStatus">Status</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        <small>The preview updates automatically as you fill out the form. Upload images to see them in the preview.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.event-image-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    overflow: hidden;
    background-color: #e4e4e4;
    background-image: var(--bg-image);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.event-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: var(--bg-image);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: blur(18px);
    transform: scale(1.08);
    z-index: 0;
}

.event-image-container > img {
    position: relative;
    z-index: 1;
}

#previewCard {
    border: 2px dashed #dee2e6;
    background-color: #f8f9fa;
}

#previewCard .card-header {
    background-color: var(--primary) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const titleInput = document.getElementById('eventTitle');
    const descriptionInput = document.getElementById('eventDescription');
    const dateInput = document.getElementById('eventDate');
    const locationInput = document.getElementById('eventLocation');
    const organizerSelect = document.getElementById('eventOrganizer');
    const statusSelect = document.getElementById('eventStatus');
    const coverImageInput = document.getElementById('coverImage');

    // Get preview elements
    const previewTitle = document.getElementById('previewTitle');
    const previewDescription = document.getElementById('previewDescription');
    const previewDate = document.getElementById('previewDate');
    const previewLocation = document.getElementById('previewLocation');
    const previewOrganizer = document.getElementById('previewOrganizer');
    const previewStatus = document.getElementById('previewStatus');
    const previewImage = document.getElementById('previewImage');
    const previewImageContainer = document.getElementById('previewImageContainer');

    // Function to update preview
    function updatePreview() {
        // Update text fields
        previewTitle.textContent = titleInput.value || 'Event Title';
        previewDescription.textContent = descriptionInput.value || 'Event description will appear here...';
        previewLocation.textContent = locationInput.value || 'Location';
        previewOrganizer.textContent = organizerSelect.options[organizerSelect.selectedIndex]?.text || 'Organizer';

        // Update date
        if (dateInput.value) {
            const date = new Date(dateInput.value);
            previewDate.textContent = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        } else {
            previewDate.textContent = 'Date';
        }

        // Update status badge
        const status = statusSelect.value;
        previewStatus.className = 'badge';
        previewStatus.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Status';

        switch(status) {
            case 'published':
                previewStatus.classList.add('badge-success');
                break;
            case 'cancelled':
                previewStatus.classList.add('badge-danger');
                break;
            case 'completed':
                previewStatus.classList.add('badge-info');
                break;
            default:
                previewStatus.classList.add('badge-warning');
        }
    }

    // Function to handle image preview
    function updateImagePreview() {
        const file = coverImageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageUrl = e.target.result;
                previewImage.src = imageUrl;
                previewImageContainer.style.setProperty('--bg-image', `url('${imageUrl}')`);
                previewImageContainer.style.backgroundImage = `var(--bg-image)`;
            };
            reader.readAsDataURL(file);
        } else {
            // Reset to placeholder
            previewImage.src = '{{ asset("images/placeholder-event.svg") }}';
            previewImageContainer.style.setProperty('--bg-image', `url('{{ asset("images/placeholder-event.svg") }}')`);
            previewImageContainer.style.backgroundImage = `var(--bg-image)`;
        }
    }

    // Add event listeners
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    dateInput.addEventListener('input', updatePreview);
    locationInput.addEventListener('input', updatePreview);
    organizerSelect.addEventListener('change', updatePreview);
    statusSelect.addEventListener('change', updatePreview);
    coverImageInput.addEventListener('change', updateImagePreview);

    // Initialize preview
    updatePreview();
    updateImagePreview();
});
</script>
@endsection

