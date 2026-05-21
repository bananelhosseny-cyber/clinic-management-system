<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
class forgetpasswordcontroller extends Controller
{
    public function sendLink(Request $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? "reset link sent!"
            : "failed to send link";
    }
}
