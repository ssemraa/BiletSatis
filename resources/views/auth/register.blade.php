@extends('layouts.guest')

@section('content')
<div class="bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold text-center mb-6">Kayıt Ol</h2>

    @if($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('auth.register') }}">
        @csrf

        <div class="mb-4">
            <input 
                type="text" 
                name="name" 
                placeholder="Ad Soyad" 
                value="{{ old('name') }}"
                required 
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
            >
        </div>

        <div class="mb-4">
            <input 
                type="email" 
                name="email" 
                placeholder="E-Posta" 
                value="{{ old('email') }}"
                required 
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
            >
        </div>

        <div class="mb-4">
            <input 
                type="password" 
                name="password" 
                placeholder="Şifre" 
                required 
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
            >
        </div>

        <div class="mb-6">
            <input 
                type="password" 
                name="password_confirmation" 
                placeholder="Şifre Tekrar" 
                required 
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
            >
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Kayıt Ol
            </button>

            <a href="{{ route('auth.login') }}" class="text-sm text-blue-600 hover:underline">
                Giriş Yap
            </a>
        </div>
    </form>
</div>
@endsection
