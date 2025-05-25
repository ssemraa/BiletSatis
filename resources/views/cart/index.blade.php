@extends('layouts.app')

@section('title', 'Sepetim')

@section('content')
<h2 class="page-title">Sepetiniz</h2>

@if(count($cart) > 0)
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th class="cart-header">Ürün Adı</th>
                    <th class="cart-header quantity-header">Adet</th>
                    <th class="cart-header price-header">Fiyat</th>
                    <th class="cart-header subtotal-header">Ara Toplam</th>
                    <th class="cart-header action-header">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $eventId => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr class="cart-row">
                        <td class="cart-cell">{{ $item['name'] }}</td>
                        <td class="cart-cell quantity-cell">
                            <form action="{{ route('cart.decrease', $eventId) }}" method="POST" class="inline-form">
                                @csrf
                                <button type="submit" class="btn quantity-btn">-</button>
                            </form>

                            <span class="quantity-text">{{ $item['quantity'] }}</span>

                          <form action="{{ route('cart.increase', $eventId) }}" method="POST" class="inline-form">
                              @csrf
                             <button type="submit" class="btn quantity-btn">+</button>
                        </form>

                        </td>
                        <td class="cart-cell price-cell">{{ number_format($item['price'], 2) }} ₺</td>
                        <td class="cart-cell subtotal-cell">{{ number_format($subtotal, 2) }} ₺</td>
                        <td class="cart-cell action-cell">
                            <form action="{{ route('cart.remove', $eventId) }}" method="POST" onsubmit="return confirm('Bu ürünü sepetten silmek istediğinize emin misiniz?');">
                                @csrf
                                <button type="submit" class="btn btn-delete">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="cart-total-row">
                    <td colspan="3" class="cart-cell total-label">Toplam</td>
                    <td class="cart-cell total-value">{{ number_format($total, 2) }} ₺</td>
                    <td class="cart-cell"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <form action="{{ route('checkout') }}" method="GET" class="checkout-form">
        <button type="submit" class="btn btn-checkout">Ödemeye Devam Et</button>
    </form>

@else
    <p class="empty-cart-message">Sepetiniz boş.</p>
@endif

@endsection
