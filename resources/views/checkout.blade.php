@extends('layouts.app')

@section('title', 'Ödeme')

@section('content')
<h2 class="text-2xl font-bold mb-4">Ödeme Yöntemi Seçimi</h2>

@if(count($cart) === 0)
    <p>Sepetiniz boş.</p>
@else
    <table style="margin-left: auto; margin-right: auto; margin-bottom:80px; max-width: 300px;">
        <thead>
            <tr>
                <th class="border px-2 py-1">Ürün Adı</th>
                <th class="border px-2 py-1">Adet</th>
                <th class="border px-2 py-1">Fiyat</th>
                <th class="border px-2 py-1">Ara Toplam</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <tr>
                    <td class="border px-2 py-1">{{ $item['name'] }}</td>
                    <td class="border px-2 py-1 text-center">{{ $item['quantity'] }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($item['price'], 2) }} ₺</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($subtotal, 2) }} ₺</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="border px-2 py-1 font-bold text-right">Toplam</td>
                <td class="border px-2 py-1 font-bold text-right">{{ number_format($total, 2) }} ₺</td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('checkout.process') }}" method="POST" class="mt-4">
        @csrf

        <label for="payment_method" class="block font-semibold mb-2">Ödeme Yöntemi:</label>
        <select id="payment_method" name="payment_method" class="border rounded px-3 py-2 mb-4 w-full max-w-xs">
            <option value="">-- Seçiniz --</option>
            <option value="credit_card">Kredi Kartı</option>
            <option value="bank_transfer">Havale / EFT</option>
            <option value="cash_on_delivery">Kapıda Ödeme</option>
        </select>

        <div id="credit_card_fields" style="display:none; max-width: 400px;">
            <label class="block font-semibold mt-2" for="card_number">Kart Numarası:</label>
            <input type="text" id="card_number" name="card_number" class="border rounded px-3 py-2 w-full" placeholder="1234 5678 9012 3456" maxlength="19">

            <label class="block font-semibold mt-2" for="expiry_date">Son Kullanma Tarihi (AA/YY):</label>
            <input type="text" id="expiry_date" name="expiry_date" class="border rounded px-3 py-2 w-full" placeholder="MM/YY" maxlength="5">

            <label class="block font-semibold mt-2" for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" class="border rounded px-3 py-2 w-full" placeholder="123" maxlength="4">
        </div>

        <div id="bank_transfer_fields" style="display:none; max-width: 400px;">
            <p class="mb-2 font-semibold">Havale/EFT için banka bilgileri:</p>
            <p>Bankamız: XYZ Bankası</p>
            <p>IBAN: TR12 3456 7890 1234 5678 9012 34</p>

            <label class="block font-semibold mt-4" for="transfer_reference">Transfer Referans Numarası:</label>
            <input type="text" id="transfer_reference" name="transfer_reference" class="border rounded px-3 py-2 w-full" placeholder="Referans numarasını giriniz">
        </div>

      

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mt-6">Ödemeyi Tamamla</button>
    </form>

    <script>
        const paymentMethodSelect = document.getElementById('payment_method');
        const creditCardFields = document.getElementById('credit_card_fields');
        const bankTransferFields = document.getElementById('bank_transfer_fields');

        paymentMethodSelect.addEventListener('change', function() {
            if(this.value === 'credit_card') {
                creditCardFields.style.display = 'block';
                bankTransferFields.style.display = 'none';
            } else if(this.value === 'bank_transfer') {
                creditCardFields.style.display = 'none';
                bankTransferFields.style.display = 'block';
            } else {
                creditCardFields.style.display = 'none';
                bankTransferFields.style.display = 'none';
            }
        });
    </script>
    @if(session('error'))
    <div style="color: red; font-weight: bold; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
        <div style="color: green; font-weight: bold; margin-bottom: 10px;">
         {{ session('success') }}
        </div>
    @endif

@endif
@endsection
