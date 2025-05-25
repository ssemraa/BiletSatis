<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;



class EventController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([

            'name' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'type' => 'required|in:Konser,Tiyatro', 
            'description' => 'nullable|string',
            'price' => 'nullable|numeric', 
            'capacity' => 'required|integer|min:1',
            
        ]);

        Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,

            'remaining_tickets' => $request->capacity,
        ]);

        return redirect()->back()->with('success');
    }

    public function index()
    {
        $users = User::where('is_approved', false)->get();
        $events = Event::orderBy('date', 'desc')->get();

     return view('admin.panel', compact('users', 'events'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success');
    }

    public function homepage()
{
    $events = Event::orderBy('date', 'asc')->get();
    $announcements = Announcement::orderBy('created_at', 'desc')->get();
    return view('welcome', compact('events', 'announcements'));
}





public function addApiEventToCart(Request $request)
{
    $event = Event::where('ticketmaster_id', $request->id)->first();

    if (!$event) {
        return redirect()->back()->withErrors('Etkinlik bulunamadı');
    }

    if ($event->remaining_tickets < 1) {
        return redirect()->back()->withErrors('Yeterli bilet yok');
    }

    $cart = session()->get('cart', []);

    if (isset($cart[$event->id])) {
        $cart[$event->id]['quantity']++;
    } else {
        $cart[$event->id] = [
            "name" => $event->name,
            "quantity" => 1,
            "price" => $event->price ?? 100,
        ];
    }

  

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Etkinlik sepete eklendi!');
}






public function showCart()
{
    $cart = session()->get('cart', []);
    return view('index', compact('cart'));  
}



}



