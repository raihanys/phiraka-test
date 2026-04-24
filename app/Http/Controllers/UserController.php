<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function generateCaptcha()
    {
        $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        session(['captcha_code' => $code]);

        $image = imagecreatetruecolor(100, 35);
        $bg = imagecolorallocate($image, 220, 220, 220);
        $fg = imagecolorallocate($image, 0, 0, 0);

        imagefill($image, 0, 0, $bg);
        imagestring($image, 5, 25, 10, $code, $fg);

        ob_start();
        imagepng($image);
        $content = ob_get_clean();
        imagedestroy($image);

        return response($content)->header('Content-Type', 'image/png');
    }

    // --- AUTH ---
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required',
            'captcha' => 'required',
        ]);

        if ($request->captcha !== session('captcha_code')) {
            return back()->withErrors(['captcha' => 'Security Image salah! Coba lagi.']);
        }

        if (Auth::attempt(['Username' => $request->Username, 'Password' => $request->Password])) {
            session()->forget('captcha_code');
            $request->session()->regenerate();
            return redirect()->route('users.index')->with('success', 'LOGIN SUKSES');
        }

        return back()->withErrors(['Username' => 'LOGIN GAGAL']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // --- CRUD ---
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

        return redirect()->route('users.index')->with('success', 'User ditambah!');
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
            'Username' => 'required|max:128|unique:tbl_user,Username' . $id,
            'Password' => 'required|min:5|max:8',
        ]);

        $user->Username = $request->Username;
        if ($request->filled('Password')) {
            $user->Password = Hash::make($request->Password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User diupdate!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User dihapus!');
    }
}
