@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')
<div class="listing__content">
    <div class="listing__heading">
        <h2>商品の出品</h2>
    </div>
    <form class="form" action="">
        <div class="form__box">
            <div class="form__group">
                <span class="form__label">商品画像
                </span>
                <div class="form__file">
                    <label class="form__file--item" for="file-upload">画像を選択する</label>
                    <input id="file-upload" class="form__file--item" type="file" name="image" accept="image/*" style="display: none;">
                </div>
                <div class="form__error"></div>
            </div>
        </div>
        <div class="form__box">
            <div class="form__box--heading">
                <h2 class="form__box--heading--item">商品の詳細</h2>
            </div>
            <div class="form__group">
                <span class="form__label">カテゴリー</span>
                <div class="form__checkbox__group">
                    <input class="form__checkbox" type="checkbox" id="fashion">
                    <label class="form__checkbox--label" for="fashion">ファッション</label>
                    <input class="form__checkbox" type="checkbox" id="home-appliances">
                    <label class="form__checkbox--label" for="home-appliances">家電</label>
                    <input class="form__checkbox"  type="checkbox" id="interior">
                    <label class="form__checkbox--label" for="interior">インテリア</label>
                    <input class="form__checkbox" type="checkbox" id="ladies">
                    <label class="form__checkbox--label" for="ladies">レディース</label>
                    <input class="form__checkbox" type="checkbox" id="mens">
                    <label class="form__checkbox--label" for="mens">メンズ</label>
                    <input class="form__checkbox" type="checkbox" id="cosmetic">
                    <label class="form__checkbox--label" for="cosmetic">コスメ</label>
                    <input class="form__checkbox" type="checkbox" id="book">
                    <label class="form__checkbox--label" for="book">本</label>
                    <input class="form__checkbox" type="checkbox" id="game">
                    <label class="form__checkbox--label" for="game">ゲーム</label>
                    <input class="form__checkbox" type="checkbox" id="sport">
                    <label class="form__checkbox--label" for="sport">スポーツ</label>
                    <input class="form__checkbox" type="checkbox" id="kitchen">
                    <label class="form__checkbox--label" for="kitchen">キッチン</label>
                    <input class="form__checkbox" type="checkbox" id="handmade">
                    <label class="form__checkbox--label" for="handmade">ハンドメイド</label>
                    <input class="form__checkbox" type="checkbox" id="accessory">
                    <label class="form__checkbox--label" for="accessory">アクセサリー</label>
                    <input class="form__checkbox" type="checkbox" id="hobby">
                    <label class="form__checkbox--label" for="hobby">おもちゃ</label>
                    <input class="form__checkbox" type="checkbox" id="baby">
                    <label class="form__checkbox--label" for="baby">ベビー・キッズ</label>
                </div>
                <div class="form__error"></div>
            </div>
            <div class="form__group">
                <span class="form__label">商品の状態</span>
                <div class="form__select">
                    <select class="form__select--input" name="situation">
                        <option value="" hidden>選択してください</option>
                        <option value="良好">良好</option>
                        <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                        <option value="状態が悪い">状態が悪い</option>
                    </select>
                </div>
                <div class="form__error"></div>
            </div>
        </div>
        <div class="form__box">
            <div class="form__box--heading">
                <h2 class="form__box--heading--item">商品名と説明</h2>
            </div>
            <div class="form__group">
                <span class="form__label">商品名</span>
                <input class="form__input" type="text">
                <div class="form__error"></div>
            </div>
            <div class="form__group">
                <span class="form__label">商品の説明</span>
                <textarea class="form__textarea" name="description" cols="50" rows="5"></textarea>
                <div class="form__error"></div>
            </div>
            <div class="form__group">
                <span class="form__label">販売価格</span>
                <input class="form__input form__input--price" id="price-input" type="text">
                <div class="form__error"></div>
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
        const listingForm = document.getElementById('listing-form');

        priceInput.value = "¥";

        priceInput.addEventListener('input', function () {
            if (!priceInput.value.startsWith("¥")) {
                priceInput.value = "¥" + priceInput.value.replace("¥", "");
            }
        });

        listingForm.addEventListener('submit', function (e) {
            priceInput.value = priceInput.value.replace("¥", "");
        });
    });
</script>
@endsection