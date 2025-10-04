<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //
    public function login()
    {
        return view ('welcome');
    }
    public function Authlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return redirect()->intended('/index')->with('success', 'Login successful! Welcome back.');
            }
            // Log::warning('Login attempt failed', [
            //     'email' => $request->email,
            //     'ip' => $request->ip(),
            //     'user_agent' => $request->userAgent(),
            //     'time' => now(),
            // ]);

            return back()->with('error', 'Invalid email or password.')
                        ->onlyInput('email');
        } catch (Exception $e) {
            Log::error('Login error', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'error_message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'time' => now(),
            ]);

            return back()->with('error', 'Invalid email or password.');
        }
    }
    public function index()
    {
        $notes = Note::latest()->get();
        $noteCount = $notes->count();
        return view('auth.index', compact('notes', 'noteCount'));
    }
}
