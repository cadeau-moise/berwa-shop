<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shopkeeper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShopkeeperAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserName' => 'required|string|max:255|unique:shopkeepers',
            'Password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shopkeeper = Shopkeeper::create([
            'UserName' => $request->UserName,
            'Password' => Hash::make($request->Password),
        ]);

        Auth::guard('shopkeeper')->login($shopkeeper);

        return redirect()->intended('/dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'UserName' => 'required|string',
            'Password' => 'required|string',
        ]);

        if (Auth::guard('shopkeeper')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'UserName' => 'The provided credentials do not match our records.',
        ])->onlyInput('UserName');
    }

    public function logout(Request $request)
    {
        Auth::guard('shopkeeper')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
