<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\announcement;

class dashboardcontroller extends Controller
{
   public function index()
    {
        $announcements = Announcement::orderby('id', 'desc')->get();
       $boxes = [];
       foreach ($announcements as $announcement) {
           $boxnumber =
           (($announcement->id -1)% 4) + 1;
           if (!isset($boxes[$boxnumber])) {
           $boxes[$boxnumber] = $announcement;
           }
           }
        return view('dashboard', compact('boxes'));
    } 
}
