<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;


class AuthController extends Controller
{
    protected $creator;

    public function __construct(CreateNewUser $creator)
    {
        $this->creator = $creator;
    }

    public function store(Request $request)
    {
        // ユーザーを作成する
        $this->creator->create($request->all());
    }

    public function register()
    {
        return view('register');
    }
}
