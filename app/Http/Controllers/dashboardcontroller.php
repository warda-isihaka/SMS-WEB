<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\announcement;

class dashboardcontroller extends Controller
{
   public function index()
    {
        $announcement = announcement::latest()->first();
        return view('dashboard', compact('announcement'));
    } 
}
