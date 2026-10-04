<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\announcement;

class dashboardcontroller extends Controller
{
   public function index()
{
    // 1. Fetch all events created by or available to the user
    $events = auth()->user()->events;

    // 2. Set default active event in session if none is currently selected
    if (!session()->has('active_event_id') && $events->isNotEmpty()) {
        session(['active_event_id' => $events->first()->id]);
    }

    $activeEventId = session('active_event_id');

    // 3. Fetch announcements for the active event
    $announcements = Announcement::where('event_id', $activeEventId)->latest()->get();

    // 4. Map announcements into boxes (for card grid view)
    $boxes = [];
    foreach ($announcements as $announcement) {
        $boxnumber = (($announcement->id - 1) % 4) + 1;
        if (!isset($boxes[$boxnumber])) {
            $boxes[$boxnumber] = $announcement;
        }
    }

    // 5. Return view with variables
    return view('dashboard', compact('boxes', 'announcements', 'events'));
}
  
}
