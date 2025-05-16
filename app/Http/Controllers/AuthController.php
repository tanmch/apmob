<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show the login form
    public function loginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the email and password fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Access the Firebase database to retrieve users
        $database = app('firebase.database');
        $users = $database->getReference('users')->getValue();
        
        // Loop through each user to check credentials
        foreach ($users as $key => $user) {
            if ($user['email'] === $request->email && Hash::check($request->password, $user['password'])) {
                // Store complete user data including role in session
                Session::put('user', [
                    'id' => $key, // Store Firebase user ID
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'user', // Default to 'user' if role not set
                ]);
                return redirect()->route('dashboard');
            }
        }
        // Error if not valid
        return back()->with('error', 'Email atau Password salah');
    }
    public function registerForm()
    {
        return view('auth.register');
    }
    // User regist request
    public function register(Request $request)
    {
        // Validasi registration input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|in:user,admin',
        ]);
        // Akses Firebase
        $database = app('firebase.database');
        $reference = $database->getReference('users');
        // Data yang akan disimpan
        $newUser = $reference->push([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'created_at' => now()->toDateTimeString(),
        ]);
        return redirect()->route('login.form')->with('success', 'Registration successful! You may now login.');
    }
    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login.form');
        }
        
        $database = app('firebase.database');
        $postsRef = $database->getReference('posts')->getValue();
        
        $user = Session::get('user');
        $isAdmin = isset($user['role']) && $user['role'] === 'admin';
        
        return view('dashboard', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'posts' => $postsRef
        ]);
    }
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login.form');
}
}