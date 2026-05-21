<?php
use App\Models\User;

class TestController
{
    public function test()
    {
        $users = User::all();
        return $users;
    }
}

