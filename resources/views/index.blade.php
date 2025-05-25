<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Anasayfa | Biletiniz.</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('owl/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('owl/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://kit.fontawesome.com/9bd4f6652f.js" crossorigin="anonymous"></script>
</head>
<body>
   <section id="menu">
    <header>
        <img id="logo" src="{{ asset('biletigniz.png') }}" alt="Site Logosu" width="180" />
    </header>
    <nav class="menu-links">
        <a href="/"><i class="fa-solid fa-house ikon"></i>Anasayfa</a>

        <div class="dropdown">
            <a href="#" class="dropbtn"><i class="fa-solid fa-ticket ikon"></i>Etkinlikler</a>
            <div class="dropdown-content">
                <a href="{{ url('/konserler') }}">Konser</a>
                <a href="{{ url('/tiyatrolar') }}">Tiyatro</a>
            </div>
        </div>

        @guest
            <a href="{{ route('auth.login') }}"><i class="fa-solid fa-right-to-bracket ikon"></i>Giriş Yap</a>
            <a href="{{ route('auth.register') }}"><i class="fa-solid fa-user-plus ikon"></i>Kayıt Ol</a>
        @endguest

        @auth
            <span class="username">Merhaba, {{ Auth::user()->name }}</span>
            <form action="{{ route('auth.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit"><i class="fa-solid fa-right-from-bracket ikon"></i>Çıkış Yap</button>
            </form>
        @endauth

        <a href="#"><i class="fa-solid fa-phone ikon"></i>İletişim</a>
    </nav>
</section>


    <section id="anasayfa">
        <div id="slider-container">
            <div class="owl-carousel owl-theme">
                {{-- Slider içerikleri buraya --}}
            </div>
        </div>

        <div id="duyurular">
            <h3>Duyurular</h3>
            <hr />
        </div>

        
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('owl/owl.carousel.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                animateOut: "animate__fadeOut",
                animateIn: "animate__fadeIn",
                smartSpeed: 1000
            });
        });
    </script>
</body>
</html>
