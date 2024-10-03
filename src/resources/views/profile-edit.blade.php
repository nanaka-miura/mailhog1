@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endsection

@section('content')
<div class="edit__content">
    <div class="edit__heading">
        <h2>プロフィール設定</h2>
    </div>
    <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="profile__img">
                @if ($user->image)
                    <img class="profile__item--img" src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                @else
                    <div class="profile__item--default-img"></div>
                @endif
                <label class="form__file" for="file-upload">画像を選択する</label>
                <input id="file-upload" class="form__file" type="file" name="image" accept="image/*" style="display: none;">
            </div>
            <div class="form__error">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">ユーザー名</span>
            <input class="form__input" type="text" name="name" value="{{ old('name',$user->name) }}">
            <div class="form__error">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">郵便番号</span>
            <input class="form__input" type="text" name="postal_code" value="{{ old('postal_code',$user->postal_code) }}">
            <div class="form__error">
                @error('postal_code')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">住所</span>
            <input class="form__input" type="text" name="address" value="{{ old('address', $user->address) }}">
            <div class="form__error">
                @error('address')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <span class="form__label">建物名</span>
            <input class="form__input" type="text" name="building" value="{{ old('building', $user->building) }}">
            <div class="form__error">
                @error('building')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection