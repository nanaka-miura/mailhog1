<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class UserController extends Controller
{
    public function profileEdit()
    {
        $user = auth()->user();
        return view('profile-edit',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('profile_image', 'public');
        $user->image = $path;
    }

        $user->save();


        return redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        $products = Product::where('user_id',$user->id)->get();
        $purchasedProducts = Order::where('user_id', $user->id)->with('product')->get();
        return view('profile',compact('user','products', 'purchasedProducts'));
    }
}
