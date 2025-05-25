<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;


class AnnouncementController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success');
   
    }



    public function index()
{
    $announcements = Announcement::orderBy('created_at', 'desc')->get();
    return view('admin.panel', compact('announcements'));
}

public function destroy(Announcement $announcement)
{
    $announcement->delete();
    return redirect()->back()->with('success');
}

}
