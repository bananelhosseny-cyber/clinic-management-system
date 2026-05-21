<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $key = 'login:' . $request->ip(); // نستخدم IP كهوية للمحاولات

        // 🔴 لو عدى 3 محاولات → بلوك 5 دقايق
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'email' => 'تم حظرك مؤقتًا. حاول بعد ' . ceil($seconds / 60) . ' دقيقة'
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            RateLimiter::clear($key);

            \App\Models\LoginDetail::create([
                'email' => $request->email,
                'login_at' => now(),
            ]);

            return redirect('/home');
        }

        RateLimiter::hit($key, 300);

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة'
        ]);
    }
}
