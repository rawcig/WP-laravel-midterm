<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organizer;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller
{
    /**
     * list all events
     */
    public function index()
    {
        $events = Event::with('organizer')->latest()->paginate(10);
        return view('backend.pages.events.index', compact('events'));
    }

    /**
     * show create form
     */
    public function create()
    {
        $organizers = Organizer::all();
        return view('backend.pages.events.create', compact('organizers'));
    }

    /**
     * store new event
     */
    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();
        
        // remove organizer name from data
        unset($validatedData['organizer']);
        
        // get organizer id from name
        if ($request->has('organizer') && !empty($request->organizer)) {
            $organizer = Organizer::where('name', $request->organizer)->first();
            if ($organizer) {
                $validatedData['organizer_id'] = $organizer->id;
            }
        }

        Event::create($validatedData);

        return redirect()->route('events.index')->with('success', 'event created!');
    }

    /**
     * show event details
     */
    public function show(Event $event)
    {
        $event->load('organizer');
        return view('backend.pages.events.show', compact('event'));
    }

    /**
     * show edit form
     */
    public function edit(Event $event)
    {
        $organizers = Organizer::all();
        return view('backend.pages.events.edit', compact('event', 'organizers'));
    }

    /**
     * update event
     */
    public function update(CreateEventRequest $request, Event $event)
    {
        $validatedData = $request->validated();
        unset($validatedData['organizer']);
        
        // handle organizer assignment
        if ($request->has('organizer') && !empty($request->organizer)) {
            $organizer = Organizer::where('name', $request->organizer)->first();
            if ($organizer) {
                $validatedData['organizer_id'] = $organizer->id;
            }
        }

        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'event updated!');
    }

    /**
     * delete event
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'event deleted!');
    }

    /**
     * show public event list
     */
    public function publicIndex()
    {
        $events = Event::where('status', 'published')
            ->where('date', '>=', now())
            ->with('organizer')
            ->latest('date')
            ->paginate(12);
        
        return view('frontend.events.index', compact('events'));
    }

    /**
     * show public event details
     */
    public function publicShow(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404);
        }
        
        $event->load('organizer', 'guests');
        return view('frontend.events.show', compact('event'));
    }
}
