<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Ambil data admin berdasarkan username
        $user = \App\Models\Admin::where('username', $request->username)->first();

        // 2. Cek apakah user ada
        if ($user) {
            // 3. Verifikasi Password (Mengecek inputan vs Bcrypt di database)
            if (Hash::check($request->password, $user->password)) {

                // Jika Berhasil: Simpan Session
                Session::put('login', true);
                Session::put('admin_id', $user->id_admin);
                Session::put('admin_nama', $user->username);

                return redirect('/dashboard');
            }
        }

        // Jika Gagal: Kembalikan ke halaman login dengan pesan error
        return redirect('/login')->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_permanent' => false,
            'discount_tier' => 0,
        ]);

        // Auto login user after registration
        Session::put('user_login', true);
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);

        return redirect()->route('home')
            ->with('success', 'Selamat datang, ' . $user->name . '! Registrasi berhasil.');
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user_login', true);
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_email', $user->email);

            return redirect()->route('home')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->back()
            ->with('error', 'Email atau password salah!')
            ->withInput();
    }

    public function userLogout()
    {
        Session::forget(['user_login', 'user_id', 'user_name', 'user_email']);
        return redirect()->route('home')
            ->with('success', 'Anda telah logout.');
    }
}