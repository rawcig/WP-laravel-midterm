<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Http\Requests\CreateOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * list all organizers
     */
    public function index()
    {
        $organizers = Organizer::latest()->paginate(10);
        return view('backend.pages.organizer.index', compact('organizers'));
    }

    /**
     * show create form
     */
    public function create()
    {
        return view('backend.pages.organizer.create');
    }

    /**
     * store new organizer
     */
    public function store(CreateOrganizerRequest $request)
    {
        Organizer::create($request->validated());
        return redirect()->route('organizer.index')->with('success', 'organizer created!');
    }

    /**
     * show organizer details
     */
    public function show(string $id)
    {
        $organizer = Organizer::with('events')->findOrFail($id);
        return view('backend.pages.organizer.show', compact('organizer'));
    }

    /**
     * show edit form
     */
    public function edit(string $id)
    {
        $organizer = Organizer::findOrFail($id);
        return view('backend.pages.organizer.edit', compact('organizer'));
    }

    /**
     * update organizer
     */
    public function update(UpdateOrganizerRequest $request, string $id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->update($request->validated());
        return redirect()->route('organizer.index')->with('success', 'organizer updated!');
    }

    /**
     * delete organizer
     */
    public function destroy(string $id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->delete();
        return redirect()->route('organizer.index')->with('success', 'organizer deleted!');
    }
}
