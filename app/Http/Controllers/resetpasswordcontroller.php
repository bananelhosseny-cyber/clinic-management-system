<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showVerificationForm()
    {
        return view('verification'); 
        // أو auth.verification حسب مكان الملف
    }

    // عرض صفحة إعادة تعيين الباسورد
        public function showResetPasswordForm(Request $request)
        {
            $email = session('reset_email', ''); // لو مخزنه في session
            return view('resetpassword', compact('email'));
        }
    }