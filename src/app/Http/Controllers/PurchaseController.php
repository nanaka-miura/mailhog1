<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class PurchaseController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        $postal_code = $user->postal_code;
        $address = $user->address;
        $building = $user->building;

        return view('purchase', compact('product','user', 'postal_code', 'address', 'building', 'id'));
    }

    public function updateAddress(AddressRequest $request, $id)
    {
        session([
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'selected_payment' => session('selected_payment'),
        ]);

        return redirect()->route('purchase',['id' => $id]);
    }

    public function purchase(PurchaseRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        session(['selected_payment' => $request->input('payment')]);

        if ($product->sold_out) {
            return redirect()->route('purchase',['id' => $id]);
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->postal_code = session('postal_code', $user->postal_code);
        $order->shipping_address = session('address', $user->address);
        $order->shipping_building = session('building', $user->building);
        $order->purchase_date = now();
        $order->payment = $request->input('payment');
        $order->save();

        $product->sold_out = true;
        $product->save();

        if ($request->input('payment') === 'カード支払い') {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 1
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/mypage',
            'cancel_url' => env('APP_URL') . '/mypage',
        ]);

        return redirect($session->url);

    } elseif ($request->input('payment') === 'コンビニ払い') {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 1
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/mypage',
            'cancel_url' => env('APP_URL') . '/mypage',
        ]);

        $session->metadata['order_id'] = $order->id;
        $session->save();

        return redirect($session->url);
    }
    }

    public function showAddressChangeForm($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        return view('address-change', compact('product','user','id'));
    }

    public function complete($id)
    {
        $order = Order::where('product_id', $id)->latest()->first();
        session()->forget('selected_payment');
        session()->forget('postal_code');
        session()->forget('address');
        session()->forget('building');

        return redirect('/mypage');
    }
}