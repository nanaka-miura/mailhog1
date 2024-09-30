<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/register">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>
            <form class="search-form" action="">
                <input class="search-form__item--input" type="text" placeholder="なにをお探しですか？">
            </form>
            <div class="header__item">
                @if(Auth::check())
                <form class="header__item--logout" action="/logout">
                    <button>ログアウト</button>
                </form>
                @else
                <a class="header__item--login" href="/login">ログイン</a>
                @endif
                <a class="header__item--mypage" href="/mypage">マイページ</a>
                <a class="header__item--sell" href="/sell">出品</a>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>