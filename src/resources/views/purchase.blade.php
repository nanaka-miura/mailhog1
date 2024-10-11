@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase__content">
    <form action="{{ route('purchase.complete', ['id' => $product->id]) }}" method="post">
        @csrf
        <div class="purchase__form">
            <div class="purchase__content--detail">
                <div class="product__detail">
                    <div class="product__detail--img">
                        <img class="product__detail--img--item" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product__detail--group">
                        <span class="product__detail--name">{{ $product->name  }}</span>
                        <div class="product__detail--price">
                            <p>&yen;</p>
                            <input class="product__detail--price--item" type="text" value="{{ number_format($product->price) }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="payment">
                    <p class="payment__header">支払い方法</p>
                    <div class="payment__item">
                        <select class="payment__item--select" name="payment">
                            <option value="" hidden>選択してください</option>
                            <option value="コンビニ払い" @if(old('payment', session('selected_payment')) == 'コンビニ払い') selected @endif>コンビニ払い</option>
                            <option value="カード支払い" @if(old('payment', session('selected_payment')) == 'カード支払い') selected @endif>カード支払い</option>
                        </select>
                    </div>
                    <div class="form__error">
                    @error('payment')
                    {{ $message }}
                    @enderror
                    </div>
                </div>
                <div class="shipping-address">
                    <div class="shipping-address__header">
                        <p class="shipping-address__header--item">配送先</p>
                        <a class="shipping-address__header--change" href="{{ route('purchase.address',['id' => $product->id]) }}">変更する</a>
                    </div>
                    <div class="shipping-address__post">
                        <p class="shipping-address__mark">〒</p>
                        <input class="shipping-address__item" type="text" name="postal_code" value="{{ session('postal_code',$user->postal_code) }}" readonly>
                    </div>
                    <div class="form__error">
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="shipping-address__address">
                        <input class="shipping-address__address--item" type="text" value="{{ session('address', $user->address) }}" name="address" readonly><br>
                        <input class="shipping-address__address--building" type="text" value="{{ session('building', $user->building) }}" name="building" readonly>
                    </div>
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="purchase__content--confirmation">
                <table class="table">
                    <tr class="table__row">
                        <th class="table__header">商品代金</th>
                        <td class="table__price">
                            <p class="table__price--mark">&yen;</p>
                            <p class="table__price--item">{{ number_format($product->price) }}</p>
                        </td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__header">支払い方法</th>
                        <td class="table__payment">
                            <p class="table__payment--item" id="selected-payment"></p></td>
                    </tr>
                </table>
                <button class="purchase-button" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.querySelector('.payment__item--select');
        const selectedPayment = document.getElementById('selected-payment');

        const savedPayment = sessionStorage.getItem('selected_payment');
        if (savedPayment) {
            selectedPayment.textContent = savedPayment;
            paymentSelect.value = savedPayment;
        }

        paymentSelect.addEventListener('change', function () {
            selectedPayment.textContent = paymentSelect.value;
            sessionStorage.setItem('selected_payment', paymentSelect.value);
        });

        const purchaseButton = document.querySelector('.purchase-button');
        purchaseButton.addEventListener('click', function () {
            sessionStorage.removeItem('selected_payment');
        });
        });
</script>

@endsection