<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile-edit');
    }
    public function mypage()
    {
        return view('profile');
    }

    public function address()
    {
        return view('address-change');
    }
}
