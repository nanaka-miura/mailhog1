<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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

    public function updateAddress(Request $request, $id)
    {
        session([
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            'building' => $request->input('building')
        ]);

        return redirect()->route('purchase',['id' => $id]);
    }

    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

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

        $product->sold_out = true;

        $order->save();
        $product->save();

        session()->forget(['postal_code','address','building']);

        return redirect('/');
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
        return redirect('/');
    }

}
