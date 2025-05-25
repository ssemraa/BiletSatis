<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; 
use App\Models\Event;

class CartController extends Controller
{

    public function index()
{
    $cart = session()->get('cart', []);
    return view('cart.index', compact('cart'));
}


public function addToCart(Request $request, $eventId)
{
     
    $cart = session()->get('cart', []);

    if(isset($cart[$eventId])) {
        $cart[$eventId]['quantity']++;
    } else {
        $event = Event::find($eventId);
        if(!$event) {
            return redirect()->back()->with('error', 'Etkinlik bulunamadı.');
        }

        
        $cart[$eventId] = [
            'name' => $event->name,
            'quantity' => 1,
            'price' => $event->price,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Sepete eklendi!');
}




public function addFromApi(Request $request)
{
    $cart = session()->get('cart', []);

    $id = md5($request->input('name') . $request->input('url')); 
    $stockKey = 'api_stock_' . $id;

    
    if (!Cache::has($stockKey)) {
        Cache::put($stockKey, 50); 
    }

    $currentStock = Cache::get($stockKey);

    if ($currentStock <= 0) {
        return redirect()->back()->with('error', 'Etkinlik için stok tükendi.');
    }

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    } else {
        $cart[$id] = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Etkinlik sepete eklendi.');
}



public function increaseQuantity($id)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        if (is_numeric($id)) {
            
            $event = Event::find($id);
            if ($event) {
                if ($cart[$id]['quantity'] < $event->remaining_tickets) {
                    $cart[$id]['quantity']++;
                    session()->put('cart', $cart);
                } else {
                    return redirect()->back()->withErrors('Yeterli bilet yok veya maksimum kapasiteye ulaşıldı.');
                }
            }
        } else {
            
            $stockKey = 'api_stock_' . $id;
            $currentStock = \Illuminate\Support\Facades\Cache::get($stockKey, 50);

            if ($cart[$id]['quantity'] < $currentStock) {
                $cart[$id]['quantity']++;
                session()->put('cart', $cart);
            } else {
                return redirect()->back()->withErrors('Yeterli bilet yok veya maksimum kapasiteye ulaşıldı.');
            }
        }
    }
    return redirect()->back();
}

public function decreaseQuantity($id)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$id])) {
        if($cart[$id]['quantity'] > 1){
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
    }
    return redirect()->back();
}


public function remove($id)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back();
}


// Sepetteki ürünleri ödeme sayfasına gönder
public function checkout()
{
    $cart = session()->get('cart', []);
    return view('checkout', compact('cart'));
}

// Ödeme işlemini simüle et, sepeti temizle ve onay sayfasına yönlendir


public function processCheckout(Request $request)
{
    $paymentMethod = $request->input('payment_method');
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Sepetiniz boş.');
    }

    if (!$paymentMethod) {
        return redirect()->back()->with('error', 'Lütfen bir ödeme yöntemi seçiniz.');
    }

    foreach ($cart as $eventId => $item) {
        if (is_numeric($eventId)) {
            $event = Event::find($eventId);

            if ($event) {
                if ($event->remaining_tickets >= $item['quantity']) {
                    $event->remaining_tickets -= $item['quantity'];
                    $event->save();
                } else {
                    return redirect()->back()->with('error', "Etkinlik '{$event->name}' için yeterli bilet yok.");
                }
            }
        } else {
            $stockKey = 'api_stock_' . $eventId;

            $currentStock = Cache::get($stockKey, 50);

            if ($currentStock < $item['quantity']) {
                return redirect()->back()->with('error', "API Etkinliği '{$item['name']}' için yeterli bilet yok.");
            }

            Cache::decrement($stockKey, $item['quantity']);
        }
    }

    // Ödeme işlemleri simülasyonu...

    session()->forget('cart');

    return redirect()->route('order.confirmation')->with('success', 'Ödeme başarılı!');
}





// Ödeme sonrası onay sayfası
public function orderConfirmation()
{
    return view('order_confirmation');
}

}
