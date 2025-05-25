<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function entry() {
        return view('auth.entry');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:3'
        ]);

        // Kullanıcı oluşturuluyor ama onaysız
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => false, 
            'role' => 'user', // kullanıcı rolü atanıyor
        ]);

        return redirect()->route('auth.login')->with('success', 'Kayıt başarılı! Hesabınız yönetici onayı bekliyor.');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Kullanıcı varsa ve şifresi doğruysa
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Onaylı değilse girişe izin verme
            if (!$user->is_approved) {
                Auth::logout();
                return back()->withErrors(['email' => 'Hesabınız henüz onaylanmadı.']);
            }
            
            if (!$user->password_changed) {
                 return redirect()->route('password.change.form');
            }
            $request->session()->regenerate();

            // Rol kontrolü
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors(['email' => 'Giriş bilgileri hatalı.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('status');
    }

    public function showChangePasswordForm()
{
    return view('auth.password_change');
}

public function changePassword(Request $request)
{
    $request->validate([
        'password' => 'required|confirmed|min:3',
    ]);

    $user = Auth::user();
    $user->password = Hash::make($request->password);
    $user->password_changed = true;
    $user->save();

   return redirect()->route('home')
                 ->with('success', 'Şifreniz başarıyla değiştirildi.');

}

}
