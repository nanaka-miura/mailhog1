<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $products = Product::where('user_id', '!=', $userId)->get();
        return view('index',compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('listing',compact('categories'));
    }

    public function store(Request $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->user_id = auth()->id();
        $product->name = $request->input('name');
        $product->content = $request->input('content');
        $product->condition = $request->input('condition');
        $product->price = (int) $request->input('price');
        $product->image = $imagePath;
        $product->sold_out = false;

        $selectedCategories = $request->input('categories');
        if (!empty($selectedCategories)) {
        $product->category_id = $selectedCategories[0];
    }

        $product->save();

        $selectedCategories = $request->input('categories');
        if (!empty($selectedCategories)) {
            $product->categories()->sync($selectedCategories);
        }

        return redirect('/');
    }

    public function show($id)
    {
        $product = Product::with(['comments.user', 'categories'])->findOrFail($id);
        return view('product-detail', compact('product'));
    }

    public function storeComment(Request $request, $productId)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'content' => $request->input('content')
        ]);

        return redirect()->route('products.show',['id' => $productId]);
    }
}
