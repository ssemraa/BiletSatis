<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;


class AdminController extends Controller
{
    public function index()
    {
        // Admin değilse erişim engellensin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Bu sayfaya sadece adminler erişebilir.');
        }

        // Tüm kullanıcıları (veya sadece onaysızları) al
        $users = User::where('role', 'user')->get(); // veya sadece onaysız: ->where('is_approved', false)


                $users = User::where('is_approved', false)->get();
                $events = Event::orderBy('date', 'desc')->get();
                $announcements = Announcement::orderBy('created_at', 'desc')->get();

        return view('admin', compact('users', 'events', 'announcements'));
    }

    public function pendingUsers()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.pending_users', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı onaylandı.');
    }

    public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    Announcement::create([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Duyuru başarıyla eklendi.');
}

public function dashboard()
{
    $events = Event::all(); // price sütunu da burada gelecek
    return view('admin', compact('events'));
}



}
