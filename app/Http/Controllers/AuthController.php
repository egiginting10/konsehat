<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.loginPage');
    }

    public function getLoginAdmin()
    {
        return view('auth.loginPageAdmin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->role === 'dokter') {
                return redirect()->route('dokter.index');
            }
        }

        return redirect()->back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if (is_null(Auth::user()->first_login)) {
                $user->first_login = now();
                $user->save();

                return redirect()->route('profil.user')->with('success', 'Silakan lengkapi profil Anda.');
            }

            return redirect()->route('user.home')->with('success', 'Berhasil login!');
        }

        return redirect()->back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }

    public function getRegister()
    {
        return view('auth.registerPage');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email',
            'password'      => 'required|min:6',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string|max:255',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        UserDetail::create([
            'user_id'   => $user->id,
            'no_hp'     => $request->no_hp,
            'alamat'    => $request->alamat
        ]);

        return redirect()->route('get.login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email',
            'password'      => 'required|min:6',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string|max:255',
        ]);

        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('get.login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda berhasil logout.');
    }
}
