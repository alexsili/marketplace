<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('status', 'A')->get();

        return view('home')->with('products', $products);
    }

    public function productShow($productId)
    {
        $product = Product::where('status', 'A')->find($productId);

        abort_if(!$product, 403);

        $reviews = Review::where('product_id', $productId)->where('status', 'A')->paginate(10);

        return view('product-show')
            ->with('product', $product)
            ->with('reviews', $reviews);
    }
}
