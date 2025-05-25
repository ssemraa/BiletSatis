<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Announcement;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
         $events = Event::latest()->take(5)->get(); 
        $announcements = Announcement::latest()->take(5)->get(); 

        return view('home', compact('events', 'announcements'));
    }
}
