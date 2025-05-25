<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Announcement;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        // Hem API'den çekilen, hem admin'in eklediği etkinlikler buraya çekilebilir
         $events = Event::latest()->take(5)->get(); // Son 5 etkinlik
        $announcements = Announcement::latest()->take(5)->get(); // Son 5 duyuru

        return view('home', compact('events', 'announcements'));
    }
}
