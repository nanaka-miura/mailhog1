<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
            </div>
        </div>
    </header>
    <main>
        <div class="login__content">
            <div class="login__heading">
                <h2>ログイン</h2>
            </div>
            <form class="form" action="">
                <div class="form__group">
                    <span class="form__label">ユーザー名</span>
                    <input class="form__input" type="text">
                    <div class="form__error"></div>
                </div>
                <div class="form__group">
                    <span class="form__label">メールアドレス</span>
                    <input class="form__input" type="email">
                    <div class="form__error"></div>
                </div>
                <div class="form__button">
                    <button class="form__button--submit">ログインする</button>
                </div>
            </form>
            <div class="register">
                <a class="register__link" href="/register">会員登録はこちら</a>
            </div>
        </div>
    </main>
</body>
</html>