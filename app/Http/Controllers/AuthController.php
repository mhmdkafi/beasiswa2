<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validate input
        $validate = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // Check login credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        // If login fails
        return back()->withErrors(['error' => 'Email atau password salah']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validate = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:3|confirmed',
        ], [
            'email.required' => 'Email wajib Diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        //tambah field name pakai nama email
        $validate['first_name'] = explode('@', $validate['email'])[0];
        $validate['full_name'] = $validate['first_name'];
        // Membuat user baru
        $user = User::create($validate);

        // Login otomatis setelah registrasi
        $request->session()->regenerate();
        Auth::login($user);

        // Redirect setelah registrasi
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
