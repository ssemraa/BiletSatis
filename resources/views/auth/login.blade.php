@extends('layouts.guest')

@section('content')
<div class="bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold text-center mb-6">Giriş Yap</h2>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('auth.login.post') }}">
        @csrf

        <div class="mb-4">
            <input 
                type="email" 
                name="email" 
                placeholder="E-Posta" 
                value="{{ old('email') }}"
                required 
                autofocus
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="mb-6">
            <input 
                type="password" 
                name="password" 
                placeholder="Şifre" 
                required
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Giriş Yap
            </button>

            <a href="{{ route('auth.register') }}" class="text-sm text-blue-600 hover:underline">
                Kayıt Ol
            </a>
        </div>
    </form>
</div>
@endsection
