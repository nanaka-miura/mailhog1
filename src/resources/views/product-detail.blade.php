@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endsection

@section('content')
<div class="product__content">
    <div class="product__img">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="product__detail">
        <div class="product__detail__item">
            <h2 class="product__name">{{ $product->name }}</h2>
            <p class="product__brand">ブランド名</p>
            <p class="product__price">¥{{ number_format($product->price) }} (税込)</p>
            <div class="product__evaluation">
                <p class="product__evaluation--star">星</p>
                <p class="product__evaluation--comment">コメント</p>
            </div>
            <form class="product__sell" action="">
                <button class="product__sell--button">購入手続きへ</button>
            </form>
            <h3 class="product__explanation__header">商品説明</h3>
            <p class="product__explanation--item">{{ $product->content }}</p>
            <h3 class="product__explanation__header">商品の情報</h3>
            <div class="product__category">
                <p class="product__category--header">カテゴリー</p>
                <div class="product__category--item">
                    <p>{{ $product->category->name }}</p>
                </div>
            </div>
            <div class="product__situation">
                <p class="product__situation--header">商品の状態</p>
                <p class="product__situation--item">{{ $product->condition }}</p>
            </div>
        </div>
        <div class="product__detail__comment">
            <h3 class="comment__header">コメント(1)</h3>
            <div class="comment__user">
                <img class="comment__user--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="comment__user--name">admin</p>
            </div>
            <p class="comment__item">こちらにコメントが入ります</p>
            <form class="comment__form" action="">
                <p class="comment__form--header">商品へのコメント</p>
                <textarea class="comment__form--textarea" name="" row="5" cols="30"></textarea>
                <button class="comment__form--button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection