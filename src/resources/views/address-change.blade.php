@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection

@section('content')
<div class="address-change__content">
    <div class="address-change__heading">
        <h2>住所の変更</h2>
    </div>
    <form class="form" action="{{ route('purchase.updateAddress',['id' => $product->id]) }}" method="post">
        @csrf
        <div class="form__group">
            <span class="form__label">郵便番号</span>
            <input class="form__input" type="text" name="postal_code"  value="{{ old('postal_code') }}">
            <div class="form__error">
                @error('postal_code')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">住所</span>
            <input class="form__input" type="text" name="address" value="{{ old('address') }}">
            <div class="form__error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">建物名</span>
            <input class="form__input" type="text" name="building" value="{{ old('building') }}">
            <div class="form__error">
                @error('building')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit">更新する</button>
        </div>
    </form>
</div>
@endsection