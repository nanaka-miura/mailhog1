@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-list__content">
    <div class="product-list__tab">
        <input class="product-list__tab--input" type="radio" name="tab" id="tab1" checked>
        <label class="product-list__tab--label" for="tab1">おすすめ</label>
        <input class="product-list__tab--input" type="radio" name="tab" id="tab2">
        <label class="product-list__tab--label" for="tab2">マイリスト</label>
        <div class="product-list__item">
            @foreach($products as $product)
            <div class="product-list__item--box" id="content1">
                <a class="product-list__item--link" href="{{ route('products.show', $product->id) }}">
                    <img class="product-list__item--img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @if ($product->sold_out)
                        <span class="sold-label">Sold</span>
                        @endif
                        <p class="product-list__item--name">{{ $product->name }}</p>
                </a>
            </div>
            @endforeach
            @if($likeProducts->isNotEmpty())
            @foreach($likeProducts as $likeProduct)
            <div class="product-list__item--box" id="content2">
                <a class="product-list__item--link" href="{{ route('products.show', $likeProduct->id) }}">
                    <img class="product-list__item--img" src="{{ asset('storage/' . $likeProduct->image) }}" alt="{{ $likeProduct->name }}">
                    @if ($likeProduct->sold_out)
                    <span class="sold-label">Sold</span>
                        @endif
                    <p class="product-list__item--name">{{ $likeProduct->name }}</p>
                </a>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection