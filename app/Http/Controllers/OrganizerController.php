<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Http\Requests\CreateOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizers = Organizer::latest()->paginate(10);
        return view('backend.pages.organizer.index', compact('organizers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.organizer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrganizerRequest $request)
    {
        Organizer::create($request->validated());
        
        return redirect()->route('organizer.index')
            ->with('success', 'Organizer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organizer = Organizer::with('events')->findOrFail($id);
        return view('backend.pages.organizer.show', compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $organizer = Organizer::findOrFail($id);
        return view('backend.pages.organizer.edit', compact('organizer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizerRequest $request, string $id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->update($request->validated());
        
        return redirect()->route('organizer.index')
            ->with('success', 'Organizer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->delete();
        
        return redirect()->route('organizer.index')
            ->with('success', 'Organizer deleted successfully!');
    }
}
