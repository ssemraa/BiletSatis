@extends('layouts.guest') {{-- veya layouts.guest vs. --}}

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-xl font-bold mb-4">Şifrenizi Değiştirin</h1>

    <form action="{{ route('password.change') }}" method="POST">
        @csrf
        <div>
            <label for="password">Yeni Şifre</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Şifre Tekrar</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Şifreyi Güncelle</button>
    </form>
</div>
@endsection
