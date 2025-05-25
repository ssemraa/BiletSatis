
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Biletiniz')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/9bd4f6652f.js" crossorigin="anonymous"></script>
</head>
<body>
    <section id="menu">
        <header>
            <h1 class="site-title">Biletiniz</h1>

        </header>
       <nav class="menu-nav">
    <a href="/home" class="menu-link"><i class="fa-solid fa-house ikon"></i> Anasayfa</a>

    <div class="dropdown">
        <a href="javascript:void(0)" class="menu-link dropbtn"><i class="fa-solid fa-ticket ikon"></i> Etkinlikler <i class="fa-solid fa-caret-down"></i></a>
        <div class="dropdown-content">
            <a href="{{ url('/konserler') }}">Konser</a>
            <a href="{{ url('/tiyatrolar') }}">Tiyatro</a>
        </div>
    </div>

    @guest
        <a href="{{ route('auth.login') }}" class="menu-link"><i class="fa-solid fa-right-to-bracket ikon"></i> Giriş Yap</a>
        <a href="{{ route('auth.register') }}" class="menu-link"><i class="fa-solid fa-user-plus ikon"></i> Kayıt Ol</a>
    @endguest

   @auth
    <span class="menu-user">Merhaba, {{ Auth::user()->name }}</span>
    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
    <a href="#" class="menu-link logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap
    </a>
@endauth


    <li class="nav-item">
    <a class="menu-link" href="{{ route('cart.index') }}">
        <i class="fa-solid fa-basket-shopping"></i> Sepetim
    </a>
</li>

</nav>
    </section>

    <main>
        @yield('content')
    </main>
</body>
</html>
