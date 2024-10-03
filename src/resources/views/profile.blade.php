@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="profile">
        <div class="profile__item">
            <img class="profile__item--img" src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
        </div>
        <div class="profile__item">
            <input class="profile__item--name" type="text" value="{{ $user->name }}" readonly>
        </div>
        <div class="profile__item">
            <a class="profile__item--link" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
    <div class="product-list__tab">
        <input class="product-list__tab--input" type="radio" name="tab" id="tab1" checked>
        <label class="product-list__tab--label" for="tab1">出品した商品</label>
        <input class="product-list__tab--input" type="radio" name="tab" id="tab2">
        <label class="product-list__tab--label" for="tab2">購入した商品</label>
        <div class="product-list__item">
            @foreach ($products as $product)
                <div class="product-list__item--box" id="content1">
                    <img class="product-list__item--img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <p class="product-list__item--name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection