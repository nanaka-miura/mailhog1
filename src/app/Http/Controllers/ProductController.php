<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $userId = Auth::id();
        $tab = $request->input('tab', 'recommended');

        $likeProducts = collect();
        $products = collect();

        if ($tab === 'mylist' && !Auth::check()) {
            $products = collect();
            $likeProducts = collect();
        } else {
            if (Auth::check() && $tab === 'mylist') {
            $likeProducts = Auth::user()->likeProducts->filter(function  ($product) use ($userId) {
                return $product->user_id !== $userId;
            });
        }

        if ($keyword) {
            $products = Product::keywordSearch($keyword)->where('user_id', '!=', $userId)->get();

            if (Auth::check()) {
                $likeProducts = $likeProducts->filter(function ($product) use ($keyword) {
                    return stripos($product->name, $keyword) !== false;
                });
            }
        } else {
            if (Auth::check()) {
                $products = Product::where('user_id', '!=', $userId)->get();
            } else {
                $products = Product::all();
            }
        }
    }
    return view('index', compact('products', 'likeProducts', 'keyword', 'tab'));
}

    public function create()
    {
        $categories = Category::all();
        return view('listing',compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->user_id = auth()->id();
        $product->name = $request->input('name');
        $product->brand = $request->input('brand');
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

    public function storeComment(CommentRequest $request, $productId)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'content' => $request->input('content')
        ]);

        return redirect()->route('products.show',['id' => $productId]);
    }

    public function like($id)
    {
        $product = Product::findOrFail($id);
        $userId = Auth::id();

        $like = $product->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        } else {
            $product->likes()->create(['user_id' => $userId]);
        }

        return redirect()->route('products.show', ['id' => $id]);
    }
}