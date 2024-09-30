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
            <div class="product-list__item--box" id="content1">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content2">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content2">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content2">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content2">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content2">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content1">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content1">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
            <div class="product-list__item--box" id="content1">
                <img class="product-list__item--img" src="{{ asset('images/firstview.jpg') }}" alt="">
                <p class="product-list__item--name">商品名</p>
            </div>
        </div>
    </div>
</div>
@endsection