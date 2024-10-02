<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{

    protected $creator;

    public function __construct(CreateNewUser $creator)
    {
        $this->creator = $creator;
    }

    public function store(Request $request)
    {
        $user = $this->creator->create($request->all());

        Auth::login($user);

        return redirect('/mypage/profile');
    }

    public function register()
    {
        return view('register');
    }
}
