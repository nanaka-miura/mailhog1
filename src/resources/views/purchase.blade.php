@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase__content">
    <div class="purchase__content--detail">
        <div class="product__detail">
            <div class="product__detail--img">
                <img class="product__detail--img--item" src="{{ asset('images/firstview.jpg') }}" alt="">
            </div>
            <div class="product__detail--group">
                <input class="product__detail--name" type="text" value="商品名" readonly>
                <div class="product__detail--price">
                    <p>&yen;</p>
                    <input class="product__detail--price--item" type="text" value="47,000" readonly>
                </div>
            </div>
        </div>
        <div class="payment">
            <p class="payment__header">支払い方法</p>
            <div class="payment__item">
                <select class="payment__item--select" name="payment">
                    <option value="" hidden>選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
            </div>
        </div>
        <div class="shipping-address">
            <div class="shipping-address__header">
                <p class="shipping-address__header--item">配送先</p>
                <a class="shipping-address__header--change" href="/purchase/address">変更する</a>
            </div>
            <div class="shipping-address__post">
                <p class="shipping-address__mark">〒</p>
                <input class="shipping-address__item" type="text" value="XXX-YYYY" readonly>
            </div>
            <div class="shipping-address__address">
                <input class="shipping-address__address--item" type="text" value="ここには住所と" readonly>
                <input class="shipping-address__address--building" type="text" value="建物が入ります" readonly>
            </div>
        </div>
    </div>
    <div class="purchase__content--confirmation">
        <table class="table">
            <tr class="table__row">
                <th class="table__header">商品代金</th>
                <td class="table__price">
                    <p class="table__price--mark">&yen;</p>
                    <p class="table__price--item">47,000</p>
                </td>
            </tr>
            <tr class="table__row">
                <th class="table__header">支払い方法</th>
                <td class="table__payment">
                    <p class="table__payment--item">コンビニ払い</p></td>
            </tr>
        </table>
        <button class="purchase-button">購入する</button>
    </div>
</div>
@endsection