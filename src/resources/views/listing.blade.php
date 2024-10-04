@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')
<div class="listing__content">
    <div class="listing__heading">
        <h2>商品の出品</h2>
    </div>
    <form class="form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__box">
            <div class="form__group">
                <span class="form__label">商品画像
                </span>
                <div class="form__file">
                    <label class="form__file--item" for="file-upload">画像を選択する</label>
                    <input id="file-upload" class="form__file--item" type="file" name="image" accept="image/*" style="display: none;">
                </div>
                <div class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__box">
            <div class="form__box--heading">
                <h2 class="form__box--heading--item">商品の詳細</h2>
            </div>
            <div class="form__group">
                <span class="form__label">カテゴリー</span>
                <div class="form__checkbox__group">
                    @foreach($categories as $category)
                        <input class="form__checkbox" type="checkbox" id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                        <label class="form__checkbox--label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                </div>
                <div class="form__error">
                    @error('categories')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">商品の状態</span>
                <div class="form__select">
                    <select class="form__select--input" name="condition" required>
                        <option value="" hidden>選択してください</option>
                        <option value="良好">良好</option>
                        <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                        <option value="状態が悪い">状態が悪い</option>
                    </select>
                </div>
                <div class="form__error">
                    @error('condition')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__box">
            <div class="form__box--heading">
                <h2 class="form__box--heading--item">商品名と説明</h2>
            </div>
            <div class="form__group">
                <span class="form__label">商品名</span>
                <input class="form__input" type="text" name="name" value="{{ old('name') }}">
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">商品の説明</span>
                <textarea class="form__textarea" name="content" cols="50" rows="5">{{ old('content') }}</textarea>
                <div class="form__error">
                    @error('content')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">販売価格</span>
                <input class="form__input form__input--price" id="price-input" type="text" name="price" value="{{ old('price') }}">
                <div class="form__error">
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit">出品する</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const priceInput = document.getElementById('price-input');
        const listingForm = document.querySelector('.form');

        if (!priceInput.value.startsWith("¥")) {
            priceInput.value = "¥" + priceInput.value;
        }

        priceInput.addEventListener('input', function () {
            if (!priceInput.value.startsWith("¥")) {
                priceInput.value = "¥" + priceInput.value.replace("¥", "");
            }
        });

        listingForm.addEventListener('submit', function (e) {
            let priceValue = priceInput.value.replace(/[^0-9]/g, '');
            if (priceValue === '') {
                e.preventDefault();
                alert('価格を入力してください。');
            } else {
                priceInput.value = priceValue;
            }
        });
    });
</script>
@endsection