<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\User;
use App\Models\Guest;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect based on user role
        if (!auth()->check()) {
            // Guest - go to public events
            return redirect()->route('events.public');
        }
        
        if (auth()->user()->isAdmin() || auth()->user()->isOrganizer()) {
            // Admin/Organizer - show dashboard
            return $this->showDashboard();
        }
        
        // Regular user - go to public events
        return redirect()->route('events.public');
    }
    
    /**
     * Show admin dashboard
     */
    private function showDashboard()
    {
        // Dashboard statistics
        $stats = [
            'total_events' => Event::count(),
            'published_events' => Event::where('status', 'published')->count(),
            'upcoming_events' => Event::where('status', 'published')->where('date', '>', now())->count(),
            'total_organizers' => Organizer::count(),
            'total_guests' => Guest::count(),
            'checked_in_guests' => Guest::where('checked_in', true)->count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'organizer_users' => User::where('role', 'organizer')->count(),
        ];
        
        // Recent events
        $recentEvents = Event::with(['organizer', 'guests'])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent guests
        $recentGuests = Guest::with(['event', 'user'])
            ->latest()
            ->take(5)
            ->get();
        
        // Top events by registration
        $topEvents = Event::withCount('guests')
            ->where('status', 'published')
            ->orderBy('guests_count', 'desc')
            ->take(5)
            ->get();
        
        return view('backend.index', compact('stats', 'recentEvents', 'recentGuests', 'topEvents'));
    }
}
