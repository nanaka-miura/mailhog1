<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserController extends Controller
{
    public function profileEdit()
    {
        $user = auth()->user();
        return view('profile-edit',compact('user'));
    }

    public function update(Request $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        $user = Auth::user();
        $user->name = $request->name;
        $user->image = $imagePath;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        $products = Product::where('user_id',$user->id)->get();
        return view('profile',compact('user','products'));
    }
}
