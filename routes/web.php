<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CartController;





Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
    }

    return redirect()->route('auth.login');
});



// Giriş ve kayıt ekranları
Route::middleware('guest')->group(function () {
    Route::get('/giris', [AuthController::class, 'showLoginForm'])->name('auth.login'); // giriş ekranı
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

    Route::get('/kayit', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/kayit', [AuthController::class, 'register'])->name('auth.register.post');
});

Route::post('/admin/users/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');

Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change.form');
Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');


// Çıkış işlemi
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Giriş sonrası erişim için yetkilendirme
Route::middleware('auth')->group(function () {

Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/redirect', function () {
        return redirect()->route('home');
    });

    // Admin panel
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Kullanıcı panel
    Route::get('/user', fn () => view('user'))->name('user.dashboard');

    // Etkinlik işlemleri (admin'e özel)
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');



    

    

    Route::get('/anasayfa', [HomeController::class, 'index'])->name('home');

    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{eventId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::post('/cart/api-add', [CartController::class, 'addFromApi'])->name('cart.api.add');

Route::post('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');

Route::post('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');

Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order/confirmation', [CartController::class, 'orderConfirmation'])->name('order.confirmation');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


});

Route::get('/konserler', fn () => view('konserler'))->name('konserler');
Route::get('/tiyatrolar', fn () => view('tiyatrolar'))->name('tiyatrolar');
