<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/register">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>
        </div>
    </header>
    <main>
        <div class="register__content">
            <div class="register__heading">
                <h2>会員登録</h2>
            </div>
            @if(session('message'))
            <div class="alert-success">
                {{ session('message') }}
            </div>
            @endif
            <form class="form" action="/register" method="post">
                @csrf
                <div class="form__group">
                    <span class="form__label">ユーザー名</span>
                    <input class="form__input" type="text" name="name" value="{{ old('name') }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror</div>
                </div>
                <div class="form__group">
                    <span class="form__label">メールアドレス</span>
                    <input class="form__input" type="email" name="email" value="{{ old('email') }}">
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror</div>
                </div>
                <div class="form__group">
                    <span class="form__label">パスワード</span>
                    <input class="form__input" type="password" name="password">
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror</div>
                </div>
                <div class="form__group">
                    <span class="form__label">確認用パスワード</span>
                    <input class="form__input" type="password" name="password_confirmation">
                    <div class="form__error">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror</div>
                </div>
                <div class="form__button">
                    <button class="form__button--submit" type="submit">登録する</button>
                </div>
            </form>
            <div class="login">
                <a class="login__link" href="/login">ログインはこちら</a>
            </div>
        </div>
    </main>
</body>
</html>