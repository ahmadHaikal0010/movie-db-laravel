<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:3'
            ]);

            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Percobaan login
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Cek jika user aktif (jika ada kolom 'is_active')
                // if (!$user->is_active) {
                //     Auth::logout();
                //     return back()->withErrors([
                //         'email' => 'Your account is not active.'
                //     ]);
                // }

                return redirect('/')->with('success', 'Login Successfully, Welcome ' . $user->name);
            }

            // Jika gagal login
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error tak terduga, bisa disimpan ke log
            Log::error('Login error: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'An unexpected error occurred. Please try again later.',
            ])->withInput();
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
