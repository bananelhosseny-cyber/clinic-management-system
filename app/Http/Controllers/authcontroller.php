<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache; // السطر ده مهم عشان الكاش يشتغل
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Pest\Support\View;

class AuthController extends Controller
{
    // هنا تحطي كل الدوال
    // Show Login Form
    public function showLogin()
    {
        return view('auth.index');
    }

    // Show Registration Form
    public function showRegister()
    {
        return view('auth.index');
    }

    // Process Login



    public function login(Request $request)
    {
        $key = 'login_attempts_' . $request->ip();


        $attempts = cache()->get($key, 0);

        if ($attempts >= 3) {
            return back()->with([
                'error' => "Wait for 30 seconds",
                'lockout_time' => 30,
            ]);
        }


        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            cache()->forget($key);
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->email == 'JohnSmith1@gmail.com') {
                return redirect('/cardiology-dashboard');
            } elseif ($user->email == 'RubyPerrin2@gmail.com') {
                return redirect('/dentist-dashboard');
            } elseif ($user->email == 'MahmoudAhmed3@gmail.com') {
                return redirect('/ortho-dashboard');
            } else {
                return redirect()->intended('/home');
            }
        }

        $newAttempts = $attempts + 1;
        cache()->put($key, $newAttempts, now()->addSeconds(30));

        if ($newAttempts >= 3) {
            return back()->with('lockout', true)->with('error', 'Too many attempts.');
        }

        return back()->with('error', 'Invaild email or password');
    }


    // Process Registration
    public function register(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:doctor,patient',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
        ]);

        $user = User::create([
            'user_type' => $request->user_type,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
        ]);

        return redirect()->route('login')->with('register_success', 'Registration successful! You can now login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // 1️⃣ عرض فورم إدخال الإيميل لإرسال كود التحقق
    public function showVerificationForm()
    {
        return view('auth.verification');
    }


    // 1. توليد الكود
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = rand(1000, 9999);
        $user = User::where('email', $request->email)->first();
        $user->verification_code = $code;
        $user->token_expiry = now()->addMinutes(10); // الكود صالح لمدة 10 دقائق
        $user->save();

        // بتبعتي الكود "الحقيقي" للإيميل مش المتشفر

        Mail::raw("Your code is: $code", function ($message) use ($user) {
            $message->to($user->email)->subject('Verification Code');
        });
        // خزني الايميل في session لاستخدامه في صفحة reset-password
        $request->session()->put('reset_email', $request->email);

        // redirect مباشرة لصفحة reset password
        return redirect()->route('password.reset.form')
            ->with('success', 'Verification code sent! Check your email.');
    }

    // 3️⃣ عرض فورم إعادة ضبط الباسورد
    public function showResetPasswordForm(Request $request)
    {
        $email = $request->session()->get('reset_email', '');
        return view('auth.reset-password', compact('email')); // نبعت email للـ view
    }

    public function storeNewPassword(Request $request)
    {
        // تحقق من البيانات
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required',
            'password' => 'required|confirmed|min:8', // confirmed يتأكد من password_confirmation
        ]);

        // جلب المستخدم
        $user = User::where('email', $request->email)->first();

        // تحقق من الكود
        if ((string)$user->verification_code !== (string)$request->verification_code) {
            return back()->withErrors(['verification_code' => 'Invalid verification code']);
        }

        // تحقق انتهاء صلاحية الكود
        if (strtotime($user->token_expiry) < time()) {
            return back()->withErrors(['verification_code' => 'Verification code expired']);
        }

        // تحديث الباسورد
        $user->password = Hash::make($request->password);
        $user->verification_code = null;
        $user->token_expiry = null;
        $user->save();

        // رجوع للـ Login مع رسالة نجاح
        return redirect()->route('login')->with('success', 'Password updated successfully! You can now login.');
    }

    // 4️⃣ معالجة إعادة ضبط الباسورد
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->verification_code)
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid verification code.');
        }

        if ($user->token_expiry < now()) {
            return back()->with('error', 'Verification code expired.');
        }

        $user->password = Hash::make($request->password);
        $user->verification_code = null;
        $user->token_expiry = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }
}
