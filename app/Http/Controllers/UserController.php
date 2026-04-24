<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Harap lakukan verifikasi reCAPTCHA.',
        ]);

        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ])->json();

        if (empty($recaptchaResponse['success'])) {
            return back()->withErrors(['captcha' => 'Verifikasi reCAPTCHA gagal. Coba lagi.']);
        }

        $credentials = [
            'Username' => $request->Username,
            'password' => $request->Password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('users.index')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['Username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required|max:128|unique:tbl_user,Username',
            'Password' => 'required|min:5|max:8',
        ]);

        User::create([
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'Username' => 'required|max:128|unique:tbl_user,Username,' . $id . ',Id',
            'Password' => 'nullable|min:5|max:8',
        ]);

        $user->Username = $request->Username;

        if ($request->filled('Password')) {
            $user->Password = Hash::make($request->Password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
