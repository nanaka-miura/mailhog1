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
            <a class="header__logo" href="/">
                <img class="header__logo--img" src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>
            <form class="search-form" action="{{ url('/') }}" method="get">
                <input class="search-form__item--input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
            </form>
            <div class="header__item header__item--button-group">
                @if(Auth::check())
                <form class="header__item--logout" action="/logout" method="post">
                    @csrf
                    <button class="header__item--logout-button">ログアウト</button>
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