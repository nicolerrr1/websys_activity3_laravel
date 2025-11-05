<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Hardcoded credentials (like your old PHP example)
        if ($username === 'nicole' && $password === 'nicole08') {
            Session::put('username', $username);
            return redirect()->route('resume');
        }

        return back()->withErrors(['Invalid login credentials!'])->withInput();
    }

    // Show resume page
    public function resume()
    {
        if (!Session::has('username')) {
            return redirect()->route('login');
        }

        return view('resume', ['username' => Session::get('username')]);
    }

    // Logout
    public function logout()
    {
        Session::flush();  // Clear all session data
        return redirect()->route('login');
    }
}
