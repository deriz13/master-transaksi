<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login () {

        return view('auth.login');
    }

    public function loginAction(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard.index');
            }
        }
        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
      Auth::logout();
      return redirect('/');
    }
}
