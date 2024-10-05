@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="product__content">
    <div class="product__img">
        <img  class="product__img--item" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="product__detail">
        <div class="product__detail__item">
            <h2 class="product__name">{{ $product->name }}</h2>
            <p class="product__brand">ブランド名</p>
            <p class="product__price">¥{{ number_format($product->price) }} (税込)</p>
            <div class="product__evaluation">
                <form class="like-form" action="{{ route('products.like', ['id' => $product->id]) }}" method="post">
                    @csrf
                    <button class="like-button" type="submit">
                        @if ($product->isLikedByUser(Auth::id()))
                        <i class="fas fa-star" style="color: #ff0000;"></i>
                        @else
                        <i class="far fa-star" style="color: #595959;"></i>
                        @endif
                    </button>
                    <span class="like-count">{{ $product->likeCount() }}</span>
                </form>
                <div class="product__comments">
                    <i class="far fa-comment" style="color: #595959;"></i>
                    <span class="comment-count">{{ $product->comments->count() }}</span>
                </div>
            </div>
            <form class="product__sell" action="{{ route('purchase', ['id' => $product->id]) }}" method="get">
                @csrf
                @if ($product->sold_out)
                <p class="product__sell--soldout-button" disabled>Sold Out</p>
                @else
                <button class="product__sell--button">購入手続きへ</button>
                @endif
            </form>
            <h3 class="product__explanation__header">商品説明</h3>
            <p class="product__explanation--item">{{ $product->content }}</p>
            <h3 class="product__explanation__header">商品の情報</h3>
            <div class="product__category">
                <p class="product__category--header">カテゴリー</p>
                <div class="product__category--item">
                    @foreach($product->categories as $category)
                        <p class="product__category--name">{{ $category->name }}</p>
                    @endforeach
                </div>
            </div>
            <div class="product__situation">
                <p class="product__situation--header">商品の状態</p>
                <p class="product__situation--item">{{ $product->condition }}</p>
            </div>
        </div>
        <div class="product__detail__comment">
            <h3 class="comment__header">コメント({{ $product->comments->count() }})</h3>
                @if ($product->comments->isNotEmpty())
                <div class="comment__user">
                    @if($product->comments->last()->user->image)
                        <img class="comment__user--img" src="{{ asset('storage/' . $product->comments->last()->user->image) }}" alt="{{ $product->comments->last()->user->name }}">
                    @else
                        <div class="comment__user--default-img"></div>
                    @endif
                    <p class="comment__user--name">{{ $product->comments->last()->user->name }}</p>
                </div>
                <p class="comment__item">{{ $product->comments->last()->content }}</p>
                @else
                <p>コメントはまだありません</p>
                @endif
            <form class="comment__form" action="{{ route('comments.store', ['id' => $product->id]) }}" method="post">
                @csrf
                <p class="comment__form--header">商品へのコメント</p>
                <textarea class="comment__form--textarea" name="content" row="5" cols="30">{{ old('content') }}</textarea>
                <div class="form__error">
                        @error('content')
                            {{ $message }}
                        @enderror
                    </div>
                <button class="comment__form--button" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection