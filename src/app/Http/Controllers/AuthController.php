<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{

    protected $creator;

    public function __construct(CreateNewUser $creator)
    {
        $this->creator = $creator;
    }

    public function store(RegisterRequest $request)
    {
        $user = $this->creator->create($request->all());
        $user->sendEmailVerificationNotification();
        return redirect('/register')->with('message', '登録が完了しました。認証メールを送信しましたのでご確認ください。');
    }

    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(LoginRequest $request)
    {

    $credentials = $request->only('email', 'password');

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if ($user && !$user->hasVerifiedEmail()) {
        $this->sendVerificationEmail($user);
        return redirect()->back()->withErrors([
            'email' => 'メール認証が必要です。認証メールを再送信しました。'
        ]);
    }

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/');
    }

    return redirect()->back()->withErrors([
        'email' => 'ログイン情報が登録されていません'
    ]);
    }

    protected function sendVerificationEmail($user)
    {
        $user->sendEmailVerificationNotification();
    }
}
