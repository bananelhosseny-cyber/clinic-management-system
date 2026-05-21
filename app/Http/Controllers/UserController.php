<?php
use App\Models\User;

class UserController
{
    public function index()
    {
        $users = User::all();
        return $users; // JSON
    }
}

