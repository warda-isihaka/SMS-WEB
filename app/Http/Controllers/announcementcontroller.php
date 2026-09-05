<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\announcement;

class announcementcontroller extends Controller
{
    public function index()
    {
        $announcements =    
        announcement::latest()->get();
        return view('dashboard', compact('announcements'));
    }
    public function create()
    {
        return view('announcement');
    }
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',

        ]);

        announcement::create([
            
            'content' => $request->content,
             'date' => $request->date,
        ]);

        return redirect()->route('announcement.create')->with('success', 'Announcement posted successfully!');
    }
}
