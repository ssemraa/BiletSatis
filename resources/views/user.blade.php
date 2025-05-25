@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Kullanıcı Paneli</h1>
    <p>Hoş geldiniz, {{ Auth::user()->name }}</p>

    

    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
@endsection
