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
        $products = Product::whereHas('reviews')->where('status', 'A')->get();

        return view('home')->with('products', $products);
    }

    public function productShow($productId)
    {
        $product = Product::whereHas('reviews')->find($productId);

        if (!$product) {
            return redirect(route('home'));
        }

        $ratings = Review::where('product_id', $productId)->paginate(10);

        return view('product-show')
            ->with('product', $product)
            ->with('ratings', $ratings);
    }
}
