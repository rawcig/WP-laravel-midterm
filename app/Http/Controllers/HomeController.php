<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalEvents = Event::count();
        $totalOrganizers = Organizer::count();
        $totalUsers = User::count();
        $publishedEvents = Event::where('status', 'published')->count();
        $upcomingEvents = Event::where('date', '>', now())->where('status', 'published')->count();
        
        // Get recent events
        $recentEvents = Event::with('organizer')->latest()->take(5)->get();
        
        // Get events by status
        $eventsByStatus = Event::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        
        return view('backend.index', compact(
            'totalEvents',
            'totalOrganizers',
            'totalUsers',
            'publishedEvents',
            'upcomingEvents',
            'recentEvents',
            'eventsByStatus'
        ));
    }
}
