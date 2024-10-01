@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection

@section('content')
<div class="address-change__content">
    <div class="address-change__heading">
        <h2>住所の変更</h2>
    </div>
    <form class="form" action="">
        <div class="form__group">
            <span class="form__label">郵便番号</span>
            <input class="form__input" type="text">
            <div class="form__error"></div>
        </div>
        <div class="form__group">
            <span class="form__label">住所</span>
            <input class="form__input" type="text">
            <div class="form__error"></div>
        </div>
        <div class="form__group">
            <span class="form__label">建物名</span>
            <input class="form__input" type="text">
            <div class="form__error"></div>
        </div>
        <div class="form__button">
            <button class="form__button--submit">更新する</button>
        </div>
    </form>
</div>
@endsection