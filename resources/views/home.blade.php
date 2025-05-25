@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')
<section id="anasayfa" style="display: flex; gap: 20px; justify-content: center; align-items: flex-start; padding: 10px;">

    {{-- Etkinlik Kartları --}}
    <div style="flex: 2;">
        
        <div id="events-list">
            @foreach($events as $event)
                <div class="event" style="width: 700px;"> 
                    <div class="event-date">
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M') }}</span>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('H:i') }}</span>
                    </div>
                    <div class="event-content">
                        <h3>{{ $event->name }}</h3>
                        <p>{{ $event->location }}</p>
                        <p>Fiyat: {{ $event->price }} ₺</p>
                        <p>Kalan Kontenjan: {{ $event->remaining_tickets }}</p>
                    <form action="{{ route('cart.add', $event->id) }}" method="POST">
    @csrf
    @if($event->remaining_tickets > 0)
        <button type="submit" class="btn btn-primary">Bilet Al</button>
    @else
        <button type="button" class="btn btn-secondary" disabled>Kontenjan Doldu</button>
    @endif
</form>


                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Duyurular Bölümü --}}
    <div style="flex: 1; margin-right:50px;">
        <h3 style="text-align: center;">DUYURU/ÖNERİ</h3>
        <div id="duyurular" style="background-color: #fff; border: 3px solid #ccc;margin-right:50px; border-radius: 8px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-height: 700px; overflow-y: auto;">
    @foreach($announcements as $index => $announcement)
        <div class="border p-3 my-2 rounded bg-gray-100">
            <h4 class="font-bold">{{ $announcement->title }}</h4>
            <p>{{ $announcement->content }}</p>
            <small class="text-gray-500 text-sm">Yayınlanma: {{ $announcement->created_at->format('d.m.Y H:i') }}</small>
        </div>
        @if(!$loop->last)
            <hr style="border-top: 1px solid #ccc; margin: 10px 0;">
        @endif
    @endforeach
</div>
    </div>

</section>
@endsection
