<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Display form to create new event
    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action. Only admins can create events.');
        }
        return view('events.create');
    }

    // Save new event to database
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') { 
            abort(403, 'Unauthorized action. Only admins can create events.');
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'event_date'  => 'nullable|date',
            ]);
        }

        $event = Event::create([
            'user_id'     => auth()->id(), // Associates event with admin/creator
            'title'       => $request->title,
            'description' => $request->description,
            'event_date'  => $request->event_date,
        ]);

        // Automatically make the newly created event active
        session(['active_event_id' => $event->id]);

        return redirect()->route('dashboard')->with('success', 'Event created successfully!');
    }

    // Switch active event
    public function selectEvent($id)
    {
     $event = Event::findOrFail($id);

    session(['active_event_id' => $event->id]);   
        

        return back()->with('success', 'Switched to ' . $event->title);
    }
}