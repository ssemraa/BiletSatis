<!DOCTYPE html>
<html>
<head>
    <title>Admin Paneli</title>
</head>
<body>
    <nav>
        @if(Auth::guard('admin')->check())
            <p>Hoş geldiniz, {{ Auth::guard('admin')->user()->name }}</p>
        @endif
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
