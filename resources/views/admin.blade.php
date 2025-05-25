@extends('layouts.guest')

@section('title', 'Admin Paneli')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white rounded shadow-md">
<div class="header-container">
    <h1 class="adminBaslik">Admin Paneli</h1>
    <a href="{{ route('auth.logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
       class="adminButon">
        Çıkış Yap
    </a>
</div>


   
    <section class="adminForm">
        <h2 class="adminBaslik">Kullanıcı Onayları</h2>
        @forelse($users as $user)
            <div class="custom-container">
                <div>
                    <p class="font-medium">{{ $user->name }} ({{ $user->email }})</p>
                </div>

                <div>
                    @if(!$user->is_approved)
                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                            @csrf
                            <button type="submit" class="adminButon">Onayla</button>
                        </form>
                    @else
                        <span class="text-green-600 font-semibold">Onaylandı</span>
                    @endif
                </div>
            </div>
        @empty
            <p>Kullanıcı bulunmamaktadır.</p>
        @endforelse
    </section>

    <div class="adminTwoColumnContainer">

  
    <section class="adminForm adminLeftColumn">
        <h2 class="adminBaslik">Duyuru Ekle</h2>
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Başlık" class="formElemanlari" required>
            <textarea name="content" placeholder="İçerik" class="formElemanlari" rows="4" required></textarea>
            <button type="submit" class="adminButon">Duyuru Ekle</button>
        </form>

        <hr style="margin:40px 0;">

        <h2 class="adminBaslik">Etkinlik Ekle</h2>
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <select name="type" class="formElemanlari" required>
                <option value="">Etkinlik Türü Seçin</option>
                <option value="Konser">Konser</option>
                <option value="Tiyatro">Tiyatro</option>
    
            </select>

            <input type="text" name="name" placeholder="Etkinlik Adı" class="formElemanlari" required>
            <input type="datetime-local" name="date" class="formElemanlari" required>
            <input type="text" name="location" placeholder="Yer" class="formElemanlari" required>
            <input type="number" name="price" placeholder="Fiyat (₺)" class="formElemanlari" required min="0" step="0.01">
            <input type="number" name="capacity" placeholder="Toplam Kontenjan" class="formElemanlari" required min="1" step="1">

            <button type="submit" class="adminButon">Etkinlik Ekle</button>
        </form>
    </section>

   
    <section class="adminRightColumn">

        <h2 class="adminBaslik">Duyurular</h2>
        @forelse($announcements as $announcement)
            <div class="custom-container" style="margin-bottom: 15px;">
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->content }}</p>
                <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="adminButon">Sil</button>
                </form>
            </div>
        @empty
            <p>Henüz duyuru yok.</p>
        @endforelse

        <hr style="margin:40px 0;">

        <h2 class="adminBaslik">Etkinlikler</h2>
        @forelse($events as $event)
            <div class="custom-container" style="margin-bottom: 15px;">
                <h3>{{ $event->name }}</h3>
                <p>{{ $event->date->format('d/m/Y H:i') }} - {{ $event->location }}</p>
                <p>Fiyat: {{ $event->price }} ₺</p>
                <form method="POST" action="{{ route('events.destroy', $event->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="adminButon">Sil</button>
                </form>
            </div>
        @empty
            <p>Henüz etkinlik yok.</p>
        @endforelse

    </section>

</div>



    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
