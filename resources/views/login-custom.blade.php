<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="{{ asset('css/stil.css') }}">
</head>
<body>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="E-Posta" required>
        <input type="password" name="password" placeholder="Şifre" required>

        <button type="submit">Giriş Yap</button>
    </form>

    <p>Hesabınız yok mu? <a href="{{ route('register') }}">Kayıt Ol</a></p>

</body>
</html>
