<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organizer;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('organizer')->latest()->paginate(10);
        return view('backend.pages.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organizers = Organizer::all();
        return view('backend.pages.events.create', compact('organizers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();
        
        // Remove 'organizer' from validated data (it's the name, not the ID)
        unset($validatedData['organizer']);
        
        // Get organizer_id from the selected organizer name
        if ($request->has('organizer') && !empty($request->organizer)) {
            $organizer = Organizer::where('name', $request->organizer)->first();
            if ($organizer) {
                $validatedData['organizer_id'] = $organizer->id;
            }
        }

        Event::create($validatedData);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('organizer');
        return view('backend.pages.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $organizers = Organizer::all();
        return view('backend.pages.events.edit', compact('event', 'organizers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEventRequest $request, Event $event)
    {
        $validatedData = $request->validated();
        
        // Remove 'organizer' from validated data (it's the name, not the ID)
        unset($validatedData['organizer']);
        
        // Get organizer_id from the selected organizer name
        if ($request->has('organizer') && !empty($request->organizer)) {
            $organizer = Organizer::where('name', $request->organizer)->first();
            if ($organizer) {
                $validatedData['organizer_id'] = $organizer->id;
            }
        }

        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}
