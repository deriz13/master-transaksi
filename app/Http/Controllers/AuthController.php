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
                return redirect()->route('master_category.index');
            }
        }
        return redirect()->back()->with('error', 'Email atau password salah.');
    }
}
