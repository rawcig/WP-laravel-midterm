<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guest::with('event');
        
        // Filter by event if specified
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        
        // Filter by status if specified
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $guests = $query->latest()->paginate(20);
        $events = Event::all();
        
        // Statistics
        $totalGuests = Guest::count();
        $confirmedGuests = Guest::where('status', 'confirmed')->count();
        $pendingGuests = Guest::where('status', 'pending')->count();
        $attendedGuests = Guest::where('status', 'attended')->count();
        
        return view('backend.pages.guests.index', compact('guests', 'events', 'totalGuests', 'confirmedGuests', 'pendingGuests', 'attendedGuests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', 'published')->where('date', '>', now())->get();
        return view('backend.pages.guests.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'event_id' => 'required|exists:events,id',
            'participation_type' => 'required|in:attendee,speaker,sponsor,volunteer,vip',
            'ticket_count' => 'required|integer|min:1|max:10',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'dietary_requirements' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['registration_status'] = 'confirmed';

        Guest::create($validated);

        return redirect()->route('guests.index')->with('success', 'Guest registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest)
    {
        $guest->load('event');
        return view('backend.pages.guests.show', compact('guest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guest $guest)
    {
        $events = Event::all();
        return view('backend.pages.guests.edit', compact('guest', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:pending,confirmed,declined,attended',
            'ticket_count' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string',
        ]);

        $guest->update($validated);

        return redirect()->route('guests.index')->with('success', 'Guest updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()->route('guests.index')->with('success', 'Guest removed successfully!');
    }

    /**
     * Bulk update guest status
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'guest_ids' => 'required|array',
            'status' => 'required|in:pending,confirmed,declined,attended',
        ]);

        Guest::whereIn('id', $request->guest_ids)->update(['status' => $request->status]);

        return redirect()->route('guests.index')->with('success', 'Guest status updated successfully!');
    }

    /**
     * Show event guest list for check-in
     */
    public function eventGuests(Event $event)
    {
        // Only admins and organizers can access
        if (!auth()->user()->isAdmin() && !auth()->user()->isOrganizer()) {
            abort(403);
        }
        
        $guests = $event->guests()->with('user')->latest()->get();
        
        // Statistics
        $stats = [
            'total' => $guests->count(),
            'confirmed' => $guests->where('status', 'confirmed')->count(),
            'checked_in' => $guests->where('checked_in', true)->count(),
            'not_checked_in' => $guests->where('checked_in', false)->count(),
        ];
        
        return view('backend.pages.guests.event-guests', compact('event', 'guests', 'stats'));
    }

    /**
     * Check in a guest
     */
    public function checkIn(Guest $guest)
    {
        // Only admins and organizers can access
        if (!auth()->user()->isAdmin() && !auth()->user()->isOrganizer()) {
            abort(403);
        }
        
        $guest->update([
            'checked_in' => true,
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Guest checked in successfully!');
    }

    /**
     * Check out a guest
     */
    public function checkOut(Guest $guest)
    {
        // Only admins and organizers can access
        if (!auth()->user()->isAdmin() && !auth()->user()->isOrganizer()) {
            abort(403);
        }
        
        $guest->update([
            'checked_in' => false,
            'checked_in_at' => null,
        ]);

        return back()->with('success', 'Guest checked out successfully!');
    }

    /**
     * Show public registration form
     */
    public function publicRegister(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404);
        }
        
        // Check if event is full
        if ($event->is_full) {
            return redirect()->route('events.public')
                ->with('error', 'This event is sold out!');
        }
        
        // if not logged in, redirect to login with return url
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please login to register for this event');
        }
        
        // Check if already registered
        $alreadyRegistered = $event->guests()
            ->where('user_id', auth()->id())
            ->exists();
        
        if ($alreadyRegistered) {
            return redirect()->route('my-events')
                ->with('info', 'You are already registered for this event');
        }
        
        return view('frontend.events.register', compact('event'));
    }

    /**
     * Store public registration
     */
    public function publicRegisterStore(Request $request, Event $event)
    {
        // ensure user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please login to complete registration');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'participation_type' => 'required|in:attendee,speaker,sponsor,volunteer,vip',
            'ticket_count' => 'required|integer|min:1|max:10',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'dietary_requirements' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['event_id'] = $event->id;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['registration_status'] = 'confirmed';

        // Create guest
        $guest = Guest::create($validated);
        
        // Generate QR code data (unique for each registration)
        $qrData = 'EVENT-' . $event->id . '-GUEST-' . $guest->id . '-' . time();
        
        // Generate QR code URL using Google Chart API (free)
        $qrCodeUrl = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($qrData) . '&choe=UTF-8';
        
        // Store QR code URL in database
        $guest->update(['qr_code' => $qrCodeUrl]);

        return redirect()->route('my-events')->with('success', 'Successfully registered for ' . $event->title . '!');
    }

    /**
     * Display user's registered events
     */
    public function myEvents()
    {
        $guests = Guest::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->paginate(20);
        
        return view('user.events.my-events', compact('guests'));
    }
}
