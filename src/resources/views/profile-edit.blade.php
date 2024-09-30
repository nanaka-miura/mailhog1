@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endsection

@section('content')
<div class="edit__content">
    <div class="edit__heading">
        <h2>プロフィール設定</h2>
    </div>
    <form class="form" action="">
        <div class="form__group">
            <label class="form__file" for="file-upload">画像を選択する</label>
            <input id="file-upload" class="form__file" type="file" name="image" accept="image/*" style="display: none;">
            <div class="form__error"></div>
        </div>
        <div class="form__group">
            <span class="form__label">ユーザー名</span>
            <input class="form__input" type="text">
            <div class="form__error"></div>
        </div>
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